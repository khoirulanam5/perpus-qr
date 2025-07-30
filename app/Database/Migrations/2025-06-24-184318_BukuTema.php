<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BukuTema extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'buku_id' => ['type' => 'INT'],
            'tema_id' => ['type' => 'INT'],
        ]);
        $this->forge->addForeignKey('buku_id', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tema_id', 'tema', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('book_tema');
    }

    public function down()
    {
        $this->forge->dropTable('book_tema');
    }
}
