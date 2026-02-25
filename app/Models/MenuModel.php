<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kategori_id', 'nama', 'deskripsi', 'harga', 'stok', 'gambar', 'tersedia'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getMenuWithKategori($tersedia = null)
    {
        $builder = $this->db->table('menu m')
            ->select('m.*, k.nama as kategori_nama')
            ->join('kategori k', 'k.id = m.kategori_id', 'left');
        
        if ($tersedia !== null) {
            $builder->where('m.tersedia', $tersedia);
        }

        return $builder->orderBy('k.urutan', 'ASC')->orderBy('m.nama', 'ASC')->get()->getResultArray();
    }
}