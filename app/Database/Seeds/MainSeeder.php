<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Urutan penting! Jangan diubah
        $this->call('KategoriSeeder');
        $this->call('UserSeeder');
        $this->call('MenuSeeder');
        $this->call('PromoSeeder');

        echo "✅ Semua data awal berhasil diisi!\n";
        echo "   - Kategori: 6 data\n";
        echo "   - Users: 2 data (admin & kasir)\n";
        echo "   - Menu: 19 data\n";
        echo "   - Promo: 2 data\n";
    }
}