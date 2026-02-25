<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\MenuModel;
use App\Models\PromoModel;

class Admin extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function dashboard()
    {
        $transaksiModel = new TransaksiModel();
        $menuModel      = new MenuModel();

        // Summary hari ini
        $today = $transaksiModel->getSummaryToday();

        // Summary bulan ini
        $bulanIni = $this->db->query("
            SELECT COUNT(*) as jumlah, COALESCE(SUM(total),0) as total
            FROM transaksi WHERE status='lunas'
            AND MONTH(created_at)=MONTH(NOW()) AND YEAR(created_at)=YEAR(NOW())
        ")->getRowArray();

        // Produk terlaris
        $terlaris = $transaksiModel->getProdukTerlaris(5);

        // Transaksi terakhir
        $terakhir = $this->db->query("
            SELECT t.*, u.nama as kasir
            FROM transaksi t
            LEFT JOIN users u ON u.id = t.user_id
            ORDER BY t.created_at DESC LIMIT 10
        ")->getResultArray();

        // Pendapatan 14 hari
        $pendapatan14Hari = $transaksiModel->getPendapatanHarian(14);

        $data = [
            'title'         => 'Dashboard Admin',
            'today'         => $today,
            'bulanIni'      => $bulanIni,
            'terlaris'      => $terlaris,
            'terakhir'      => $terakhir,
            'pendapatan14'  => $pendapatan14Hari,
            'totalMenu'     => $menuModel->countAll(),
        ];

        return view('admin/dashboard', $data);
    }

    public function promo()
    {
        $promoModel = new PromoModel();
        return view('admin/promo', [
            'title' => 'Manajemen Promo',
            'promo' => $promoModel->orderBy('id','DESC')->findAll(),
        ]);
    }

    public function simpanPromo()
    {
        $promoModel = new PromoModel();
        $promoModel->insert([
            'kode'          => strtoupper($this->request->getPost('kode')),
            'nama'          => $this->request->getPost('nama'),
            'tipe'          => $this->request->getPost('tipe'),
            'nilai'         => $this->request->getPost('nilai'),
            'min_transaksi' => $this->request->getPost('min_transaksi') ?: 0,
            'aktif'         => 1,
            'expired_at'    => $this->request->getPost('expired_at') ?: null,
        ]);

        return redirect()->to('/admin/promo')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function hapusPromo($id)
    {
        $promoModel = new PromoModel();
        $promoModel->delete($id);
        return redirect()->to('/admin/promo')->with('success', 'Promo dihapus.');
    }

    public function apiPendapatan()
    {
        $transaksiModel = new TransaksiModel();
        $data = $transaksiModel->getPendapatanHarian(14);
        return $this->response->setJSON($data);
    }
}