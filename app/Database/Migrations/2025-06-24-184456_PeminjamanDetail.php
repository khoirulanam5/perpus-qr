<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PeminjamanDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'peminjaman_id'  => ['type' => 'INT'],
            'buku_id'        => ['type' => 'INT'],
            'jumlah'         => ['type' => 'INT', 'default' => 1],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('peminjaman_id', 'peminjaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('buku_id', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman_detail');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman_detail');
    }
}
