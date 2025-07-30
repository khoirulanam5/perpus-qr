<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Buku extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'judul'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'penulis'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'penerbit'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'tahun_terbit'     => ['type' => 'YEAR'],
            'isbn'             => ['type' => 'VARCHAR', 'constraint' => 20],
            'rak_id'           => ['type' => 'INT', 'null' => true],
            'total_eksemplar'  => ['type' => 'INT', 'default' => 0],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rak_id', 'rak', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('buku');
    }

    public function down()
    {
        $this->forge->dropTable('buku');
    }
}
