<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Semua',    'urutan' => 0],
            ['nama' => 'Minuman',  'urutan' => 1],
            ['nama' => 'Mie',      'urutan' => 2],
            ['nama' => 'Pizza',    'urutan' => 3],
            ['nama' => 'Snack',    'urutan' => 4],
            ['nama' => 'Nasi',     'urutan' => 5],
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}