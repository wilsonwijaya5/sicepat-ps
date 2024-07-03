<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengantaran extends Migration
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
            'region' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nama_kurir' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jumlah_paket' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengantaran');
    }

    public function down()
    {
        $this->forge->dropTable('pengantaran');
    }
}
