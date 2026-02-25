<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'no_invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'tipe_order' => [
                'type'       => 'ENUM',
                'constraint' => ['dine_in', 'takeaway', 'delivery'],
                'default'    => 'dine_in',
            ],
            'nama_pelanggan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Umum',
            ],
            'no_meja' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'metode_bayar' => [
                'type'       => 'ENUM',
                'constraint' => ['tunai', 'qris', 'transfer'],
                'default'    => 'tunai',
            ],
            'subtotal' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'diskon' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'total' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'bayar' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'kembalian' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'promo_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'lunas', 'batal'],
                'default'    => 'pending',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}