<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'transaksi_id' => [
                'type' => 'INT',
            ],
            'menu_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'nama_menu' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'harga' => [
                'type' => 'INT',
            ],
            'qty' => [
                'type'    => 'INT',
                'default' => 1,
            ],
            'subtotal' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('transaksi_id', 'transaksi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('menu_id', 'menu', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('transaksi_detail');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_detail');
    }
}