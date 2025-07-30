<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PengaturanDenda extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'auto_increment' => true],
            'denda_per_hari'    => ['type' => 'INT'],
            'denda_buku_hilang' => ['type' => 'INT'],
            'maksimal_telat'    => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengaturan_denda');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan_denda');
    }
}
