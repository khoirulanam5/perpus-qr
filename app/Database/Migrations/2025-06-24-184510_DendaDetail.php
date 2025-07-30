<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DendaDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'denda_id'    => ['type' => 'INT'],
            'buku_id'     => ['type' => 'INT'],
            'jenis'       => ['type' => 'ENUM("terlambat", "hilang")'],
            'jumlah'      => ['type' => 'INT', 'default' => 1],
            'nominal'     => ['type' => 'INT'], // per buku / per keterlambatan
            'subtotal'    => ['type' => 'INT'], // jumlah × nominal
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('denda_id', 'denda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('buku_id', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('denda_detail');
    }

    public function down()
    {
        $this->forge->dropTable('denda_detail');
    }
}
