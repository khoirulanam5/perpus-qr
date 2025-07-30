<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BukuMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'buku_id'         => ['type' => 'INT'],
            'jumlah_masuk'    => ['type' => 'INT'],
            'tanggal_masuk'   => ['type' => 'DATE'],
            'diperoleh_dari'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'keterangan'      => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('buku_id', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('buku_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('buku_masuk');
    }
}
