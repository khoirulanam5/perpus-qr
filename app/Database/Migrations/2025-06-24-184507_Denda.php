<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Denda extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'anggota_id'     => ['type' => 'INT'],
            'user_id'        => ['type' => 'INT'], // admin/petugas
            'peminjaman_id'  => ['type' => 'INT', 'null' => true],
            'total_denda'    => ['type' => 'INT', 'default' => 0],
            'status'         => ['type' => 'ENUM("belum_dibayar", "sudah_dibayar")', 'default' => 'belum_dibayar'],
            'keterangan'     => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('peminjaman_id', 'peminjaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('denda');
    }

    public function down()
    {
        $this->forge->dropTable('denda');
    }
}
