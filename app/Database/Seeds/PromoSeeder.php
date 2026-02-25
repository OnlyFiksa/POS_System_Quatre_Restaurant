<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode'          => 'MANTAP05',
                'nama'          => 'Diskon 5%',
                'tipe'          => 'persen',
                'nilai'         => 5,
                'min_transaksi' => 50000,
                'aktif'         => 1,
                'expired_at'    => null,
            ],
            [
                'kode'          => 'HEMAT10K',
                'nama'          => 'Hemat 10 Ribu',
                'tipe'          => 'nominal',
                'nilai'         => 10000,
                'min_transaksi' => 100000,
                'aktif'         => 1,
                'expired_at'    => null,
            ],
        ];

        $this->db->table('promo')->insertBatch($data);
    }
}