<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BukuKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'buku_id'         => ['type' => 'INT'],
            'jumlah_keluar'   => ['type' => 'INT'],
            'tanggal_keluar'  => ['type' => 'DATE'],
            'jenis_keluar'    => ['type' => 'ENUM("hilang","rusak","donasi","musnahkan")'],
            'keterangan'      => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('buku_id', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('buku_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('buku_keluar');
    }
}
