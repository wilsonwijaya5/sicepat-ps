<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bukti extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tanggal_terima' => [
                'type' => 'DATE',
            ],
            'waktu' => [
                'type' => 'TIME',
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bukti');
    }

    public function down()
    {
        $this->forge->dropTable('bukti');
    }
}
