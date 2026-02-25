<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\KategoriModel;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use App\Models\PromoModel;
use App\Models\UserModel;
use App\Models\ApiKeyModel;

class ApiController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Helper response
    private function respond($status, $message, $data = null, $code = 200)
    {
        $response = [
            'status'  => $status,
            'message' => $message,
        ];
        if ($data !== null) {
            $response['data'] = $data;
        }
        return $this->response->setJSON($response)->setStatusCode($code);
    }

    // ================================================================
    // AUTH - Login & Generate API Key
    // POST /api/login
    // Body: username, password
    // ================================================================
    public function login()
    {
        $userModel  = new UserModel();
        $apiKeyModel = new ApiKeyModel();

        $input    = $this->request->getJSON(true) ?? $this->request->getPost();
        $username = $input['username'] ?? null;
        $password = $input['password'] ?? null;

        if (!$username || !$password) {
            return $this->respond('error', 'Username dan password wajib diisi.', null, 400);
        }

        $user = $userModel->getByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->respond('error', 'Username atau password salah.', null, 401);
        }

        // Generate API key
        $key = $apiKeyModel->generateKey($user['id']);

        return $this->respond('success', 'Login berhasil.', [
            'api_key'  => $key,
            'nama'     => $user['nama'],
            'username' => $user['username'],
            'role'     => $user['role'],
        ]);
    }

    // ================================================================
    // AUTH - Logout (hapus API key)
    // POST /api/logout
    // Header: X-API-KEY
    // ================================================================
    public function logout()
    {
        $apiKey      = $this->request->getHeaderLine('X-API-KEY');
        $apiKeyModel = new ApiKeyModel();
        $apiKeyModel->where('api_key', $apiKey)->delete();

        return $this->respond('success', 'Logout berhasil.');
    }

    // ================================================================
    // MENU - Ambil semua menu
    // GET /api/menu
    // Header: X-API-KEY
    // ================================================================
    public function menu()
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->getMenuWithKategori(1);

        return $this->respond('success', 'Data menu berhasil diambil.', $menu);
    }

    // ================================================================
    // MENU - Detail satu menu
    // GET /api/menu/{id}
    // Header: X-API-KEY
    // ================================================================
    public function menuDetail($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if (!$menu) {
            return $this->respond('error', 'Menu tidak ditemukan.', null, 404);
        }

        return $this->respond('success', 'Detail menu berhasil diambil.', $menu);
    }

    // ================================================================
    // KATEGORI - Ambil semua kategori
    // GET /api/kategori
    // Header: X-API-KEY
    // ================================================================
    public function kategori()
    {
        $kategoriModel = new KategoriModel();
        $data = $kategoriModel->orderBy('urutan', 'ASC')->findAll();

        return $this->respond('success', 'Data kategori berhasil diambil.', $data);
    }

    // ================================================================
    // TRANSAKSI - Ambil semua transaksi
    // GET /api/transaksi
    // Header: X-API-KEY
    // ================================================================
    public function transaksi()
    {
        $list = $this->db->query("
            SELECT t.*, u.nama as kasir
            FROM transaksi t
            LEFT JOIN users u ON u.id = t.user_id
            ORDER BY t.created_at DESC
            LIMIT 50
        ")->getResultArray();

        return $this->respond('success', 'Data transaksi berhasil diambil.', $list);
    }

    // ================================================================
    // TRANSAKSI - Detail transaksi
    // GET /api/transaksi/{id}
    // Header: X-API-KEY
    // ================================================================
    public function transaksiDetail($id)
    {
        $transaksiModel = new TransaksiModel();
        $trx = $transaksiModel->getWithDetail($id);

        if (!$trx) {
            return $this->respond('error', 'Transaksi tidak ditemukan.', null, 404);
        }

        return $this->respond('success', 'Detail transaksi berhasil diambil.', $trx);
    }

    // ================================================================
    // TRANSAKSI - Buat transaksi baru
    // POST /api/transaksi
    // Header: X-API-KEY
    // Body: items (JSON), tipe_order, metode_bayar, bayar, promo_code, nama_pelanggan, catatan
    // ================================================================
    public function buatTransaksi()
    {
        $transaksiModel = new TransaksiModel();
        $detailModel    = new TransaksiDetailModel();
        $promoModel     = new PromoModel();
        $apiKeyModel    = new ApiKeyModel();

        $apiKey  = $this->request->getHeaderLine('X-API-KEY');
        $apiUser = $apiKeyModel->getUserByKey($apiKey);

        $items       = $this->request->getPost('items');
        $tipeOrder   = $this->request->getPost('tipe_order') ?? 'dine_in';
        $metodeBayar = $this->request->getPost('metode_bayar') ?? 'tunai';
        $bayar       = (int) $this->request->getPost('bayar');
        $promoCode   = trim($this->request->getPost('promo_code') ?? '');
        $catatan     = $this->request->getPost('catatan');
        $namaPelanggan = $this->request->getPost('nama_pelanggan') ?: 'Umum';

        if (!$items) {
            return $this->respond('error', 'Items tidak boleh kosong.', null, 400);
        }

        $items = json_decode($items, true);
        if (!$items || count($items) === 0) {
            return $this->respond('error', 'Items tidak valid.', null, 400);
        }

        // Hitung subtotal
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }

        // Cek promo
        $diskon    = 0;
        $promoUsed = null;
        if ($promoCode) {
            $promo = $promoModel->getByKode($promoCode);
            if ($promo && $subtotal >= $promo['min_transaksi']) {
                $promoUsed = $promo['kode'];
                $diskon = $promo['tipe'] === 'persen'
                    ? round($subtotal * $promo['nilai'] / 100)
                    : $promo['nilai'];
            }
        }

        $total     = $subtotal - $diskon;
        $kembalian = max(0, $bayar - $total);

        // Simpan transaksi
        $noInvoice   = $transaksiModel->generateInvoice();
        $transaksiId = $transaksiModel->insert([
            'no_invoice'     => $noInvoice,
            'user_id'        => $apiUser['user_id'],
            'tipe_order'     => $tipeOrder,
            'nama_pelanggan' => $namaPelanggan,
            'metode_bayar'   => $metodeBayar,
            'subtotal'       => $subtotal,
            'diskon'         => $diskon,
            'total'          => $total,
            'bayar'          => $bayar,
            'kembalian'      => $kembalian,
            'promo_code'     => $promoUsed,
            'status'         => 'lunas',
            'catatan'        => $catatan,
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

        return $this->respond('success', 'Transaksi berhasil dibuat.', [
            'transaksi_id' => $transaksiId,
            'no_invoice'   => $noInvoice,
            'total'        => $total,
            'kembalian'    => $kembalian,
        ], 201);
    }

    // ================================================================
    // DASHBOARD - Statistik
    // GET /api/dashboard
    // Header: X-API-KEY
    // ================================================================
    public function dashboard()
    {
        $transaksiModel = new TransaksiModel();

        $today = $transaksiModel->getSummaryToday();

        $bulanIni = $this->db->query("
            SELECT COUNT(*) as jumlah, COALESCE(SUM(total),0) as total
            FROM transaksi WHERE status='lunas'
            AND MONTH(created_at)=MONTH(NOW()) AND YEAR(created_at)=YEAR(NOW())
        ")->getRowArray();

        $terlaris = $transaksiModel->getProdukTerlaris(5);
        $pendapatan14 = $transaksiModel->getPendapatanHarian(14);

        return $this->respond('success', 'Data dashboard berhasil diambil.', [
            'hari_ini'      => $today,
            'bulan_ini'     => $bulanIni,
            'produk_terlaris' => $terlaris,
            'pendapatan_14_hari' => $pendapatan14,
        ]);
    }

    // ================================================================
    // PROMO - Cek promo
    // POST /api/promo/cek
    // Header: X-API-KEY
    // Body: kode, subtotal
    // ================================================================
    public function cekPromo()
    {
        $promoModel = new PromoModel();
        $kode       = trim($this->request->getPost('kode'));
        $subtotal   = (int) $this->request->getPost('subtotal');

        $promo = $promoModel->getByKode($kode);
        if (!$promo) {
            return $this->respond('error', 'Kode promo tidak valid.', null, 404);
        }

        if ($subtotal < $promo['min_transaksi']) {
            return $this->respond('error', 'Minimum transaksi Rp ' . number_format($promo['min_transaksi'], 0, ',', '.'), null, 400);
        }

        $diskon = $promo['tipe'] === 'persen'
            ? round($subtotal * $promo['nilai'] / 100)
            : $promo['nilai'];

        return $this->respond('success', 'Promo valid.', [
            'kode'   => $promo['kode'],
            'nama'   => $promo['nama'],
            'diskon' => $diskon,
        ]);
    }
}