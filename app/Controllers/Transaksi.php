<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $list = $this->db->query("
            SELECT t.*, u.nama as kasir
            FROM transaksi t
            LEFT JOIN users u ON u.id = t.user_id
            ORDER BY t.created_at DESC
        ")->getResultArray();

        return view('admin/transaksi/index', [
            'title' => 'Riwayat Transaksi',
            'list'  => $list,
        ]);
    }

    public function detail($id)
    {
        $transaksiModel = new TransaksiModel();
        $trx = $transaksiModel->getWithDetail($id);
        return view('admin/transaksi/detail', ['trx' => $trx, 'title' => 'Detail Transaksi']);
    }

    public function struk($id)
    {
        $transaksiModel = new TransaksiModel();
        $trx = $transaksiModel->getWithDetail($id);
        return view('kasir/struk', ['trx' => $trx]);
    }

    public function batal($id)
    {
        $this->db->table('transaksi')->where('id', $id)->update(['status' => 'batal']);
        return redirect()->to('/admin/transaksi')->with('success', 'Transaksi dibatalkan.');
    }
}