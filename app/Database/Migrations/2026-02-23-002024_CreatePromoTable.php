<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePromoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'kode' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tipe' => [
                'type'       => 'ENUM',
                'constraint' => ['persen', 'nominal'],
                'default'    => 'persen',
            ],
            'nilai' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'min_transaksi' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'aktif' => [
                'type'    => 'TINYINT',
                'default' => 1,
            ],
            'expired_at' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('promo');
    }

    public function down()
    {
        $this->forge->dropTable('promo');
    }
}