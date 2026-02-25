<?php namespace App\Models;
use CodeIgniter\Model;

class PromoModel extends Model
{
    protected $table = 'promo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode', 'nama', 'tipe', 'nilai', 'min_transaksi', 'aktif', 'expired_at'];
    protected $useTimestamps = false;

    public function getByKode($kode)
    {
        return $this->where('kode', strtoupper($kode))
                    ->where('aktif', 1)
                    ->where('(expired_at IS NULL OR expired_at >= CURDATE())')
                    ->first();
    }
}