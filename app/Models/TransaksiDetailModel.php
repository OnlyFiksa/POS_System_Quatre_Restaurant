<?php namespace App\Models;
use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transaksi_id', 'menu_id', 'nama_menu', 'harga', 'qty', 'subtotal'];
    protected $useTimestamps = false;
}