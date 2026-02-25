<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Ambil id kategori
        $minuman = $this->db->table('kategori')->where('nama', 'Minuman')->get()->getRowArray()['id'];
        $mie     = $this->db->table('kategori')->where('nama', 'Mie')->get()->getRowArray()['id'];
        $pizza   = $this->db->table('kategori')->where('nama', 'Pizza')->get()->getRowArray()['id'];
        $snack   = $this->db->table('kategori')->where('nama', 'Snack')->get()->getRowArray()['id'];
        $nasi    = $this->db->table('kategori')->where('nama', 'Nasi')->get()->getRowArray()['id'];

        $data = [
            // Minuman
            ['kategori_id' => $minuman, 'nama' => 'Americano',          'harga' => 18000, 'stok' => 49,  'tersedia' => 1],
            ['kategori_id' => $minuman, 'nama' => 'Butterscotch Coffee', 'harga' => 25000, 'stok' => 45,  'tersedia' => 1],
            ['kategori_id' => $minuman, 'nama' => 'Caffe Latte',         'harga' => 22000, 'stok' => 40,  'tersedia' => 1],
            ['kategori_id' => $minuman, 'nama' => 'Ice Tea',             'harga' => 8000,  'stok' => 35,  'tersedia' => 1],
            ['kategori_id' => $minuman, 'nama' => 'Chocolate Latte',     'harga' => 23000, 'stok' => 42,  'tersedia' => 1],
            ['kategori_id' => $minuman, 'nama' => 'Matcha Latte',        'harga' => 24000, 'stok' => 48,  'tersedia' => 1],
            ['kategori_id' => $minuman, 'nama' => 'Healthy Breakfast',   'harga' => 25000, 'stok' => 14,  'tersedia' => 1],
            // Mie
            ['kategori_id' => $mie,     'nama' => 'Fried Kwetiau',       'harga' => 28000, 'stok' => 40,  'tersedia' => 1],
            ['kategori_id' => $mie,     'nama' => 'Indomie Goreng',      'harga' => 12000, 'stok' => 100, 'tersedia' => 1],
            ['kategori_id' => $mie,     'nama' => 'Indomie Kuah',        'harga' => 12000, 'stok' => 100, 'tersedia' => 1],
            // Pizza
            ['kategori_id' => $pizza,   'nama' => 'Cheese Pizza',        'harga' => 42000, 'stok' => 21,  'tersedia' => 1],
            ['kategori_id' => $pizza,   'nama' => 'Meat Lover Pizza',    'harga' => 52000, 'stok' => 15,  'tersedia' => 1],
            // Snack
            ['kategori_id' => $snack,   'nama' => 'Chicken Nugget',      'harga' => 20000, 'stok' => 32,  'tersedia' => 1],
            ['kategori_id' => $snack,   'nama' => 'Chicken Smackdown',   'harga' => 32000, 'stok' => 48,  'tersedia' => 1],
            ['kategori_id' => $snack,   'nama' => 'Potato Chips',        'harga' => 12000, 'stok' => 45,  'tersedia' => 1],
            ['kategori_id' => $snack,   'nama' => 'Potato Wedges',       'harga' => 18000, 'stok' => 37,  'tersedia' => 1],
            ['kategori_id' => $snack,   'nama' => 'Tahu Sumedang',       'harga' => 15000, 'stok' => 34,  'tersedia' => 1],
            // Nasi
            ['kategori_id' => $nasi,    'nama' => 'Ramen',               'harga' => 30000, 'stok' => 27,  'tersedia' => 1],
            ['kategori_id' => $nasi,    'nama' => 'Signature Ramen',     'harga' => 35000, 'stok' => 24,  'tersedia' => 1],
        ];

        $this->db->table('menu')->insertBatch($data);
    }
}