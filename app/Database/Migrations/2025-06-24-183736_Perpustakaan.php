<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perpustakaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'auto_increment' => true],
            'nama'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'alamat'    => ['type' => 'TEXT'],
            'kontak'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'kepala'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('perpustakaan');
    }

    public function down()
    {
        $this->forge->dropTable('perpustakaan');
    }
}
