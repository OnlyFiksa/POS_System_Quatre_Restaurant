<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\KategoriModel;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use App\Models\PromoModel;

class Kasir extends BaseController
{
    public function index()
    {
        $menuModel     = new MenuModel();
        $kategoriModel = new KategoriModel();

        $data = [
            'title'    => 'Kasir - POS Restoran',
            'menu'     => $menuModel->getMenuWithKategori(1),
            'kategori' => $kategoriModel->orderBy('urutan', 'ASC')->findAll(),
            'kasir'    => session()->get('nama'),
        ];

        return view('kasir/index', $data);
    }

    public function checkout()
    {
        $transaksiModel = new TransaksiModel();
        $detailModel    = new TransaksiDetailModel();
        $promoModel     = new PromoModel();

        $items      = $this->request->getPost('items'); // JSON string
        $tipeOrder  = $this->request->getPost('tipe_order');
        $metodeBayar= $this->request->getPost('metode_bayar');
        $bayar      = (int) $this->request->getPost('bayar');
        $promoCode  = trim($this->request->getPost('promo_code') ?? '');
        $catatan    = $this->request->getPost('catatan');
        $namaPelanggan = $this->request->getPost('nama_pelanggan') ?: 'Umum';

        $items = json_decode($items, true);
        if (!$items || count($items) === 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Keranjang kosong!']);
        }

        // Hitung subtotal
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }

        // Promo
        $diskon = 0;
        $promoUsed = null;
        if ($promoCode) {
            $promo = $promoModel->getByKode($promoCode);
            if ($promo && $subtotal >= $promo['min_transaksi']) {
                $promoUsed = $promo['kode'];
                if ($promo['tipe'] === 'persen') {
                    $diskon = round($subtotal * $promo['nilai'] / 100);
                } else {
                    $diskon = $promo['nilai'];
                }
            }
        }

        $total    = $subtotal - $diskon;
        $kembalian = max(0, $bayar - $total);

        // Simpan transaksi
        $noInvoice = $transaksiModel->generateInvoice();

        $transaksiId = $transaksiModel->insert([
            'no_invoice'    => $noInvoice,
            'user_id'       => session()->get('user_id'),
            'tipe_order'    => $tipeOrder,
            'nama_pelanggan'=> $namaPelanggan,
            'metode_bayar'  => $metodeBayar,
            'subtotal'      => $subtotal,
            'diskon'        => $diskon,
            'total'         => $total,
            'bayar'         => $bayar,
            'kembalian'     => $kembalian,
            'promo_code'    => $promoUsed,
            'status'        => 'lunas',
            'catatan'       => $catatan,
        ]);

        // Simpan detail
        foreach ($items as $item) {
            $detailModel->insert([
                'transaksi_id' => $transaksiId,
                'menu_id'      => $item['id'],
                'nama_menu'    => $item['nama'],
                'harga'        => $item['harga'],
                'qty'          => $item['qty'],
                'subtotal'     => $item['harga'] * $item['qty'],
            ]);
        }

        return $this->response->setJSON([
            'success'    => true,
            'transaksi_id' => $transaksiId,
            'no_invoice' => $noInvoice,
        ]);
    }

    public function struk($id)
    {
        $transaksiModel = new TransaksiModel();
        $trx = $transaksiModel->getWithDetail($id);

        if (!$trx) {
            return redirect()->to('/kasir');
        }

        return view('kasir/struk', ['trx' => $trx]);
    }

    public function cekPromo()
    {
        $promoModel = new PromoModel();
        $kode       = trim($this->request->getPost('kode'));
        $subtotal   = (int) $this->request->getPost('subtotal');

        $promo = $promoModel->getByKode($kode);
        if (!$promo) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kode promo tidak valid.']);
        }
        if ($subtotal < $promo['min_transaksi']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Minimum transaksi Rp ' . number_format($promo['min_transaksi'], 0, ',', '.')
            ]);
        }

        $diskon = $promo['tipe'] === 'persen'
            ? round($subtotal * $promo['nilai'] / 100)
            : $promo['nilai'];

        return $this->response->setJSON([
            'success' => true,
            'nama'    => $promo['nama'],
            'diskon'  => $diskon,
        ]);
    }
}