<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Peminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'user_id'         => ['type' => 'INT'], // anggota peminjam
            'tanggal_pinjam'  => ['type' => 'DATE'],
            'tanggal_due'     => ['type' => 'DATE'], // batas pengembalian
            'tanggal_kembali' => ['type' => 'DATE', 'null' => true], // realisasi pengembalian
            'status'          => ['type' => 'ENUM("dipinjam", "dikembalikan", "terlambat")', 'default' => 'dipinjam'],
            'denda'           => ['type' => 'INT', 'default' => 0],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman');
    }
}
