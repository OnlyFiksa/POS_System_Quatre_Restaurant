<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'       => 'Administrator',
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Kasir 1',
                'username'   => 'kasir',
                'password'   => password_hash('kasir123', PASSWORD_DEFAULT),
                'role'       => 'kasir',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Putra',
                'username'   => 'putra',
                'password'   => password_hash('putra123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Taufik',
                'username'   => 'taufik',
                'password'   => password_hash('taufik123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Fajar',
                'username'   => 'fajar',
                'password'   => password_hash('fajar123', PASSWORD_DEFAULT),
                'role'       => 'kasir',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}