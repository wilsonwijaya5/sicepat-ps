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
            'kurir_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'jumlah_paket' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kurir_id', 'kurir', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengantaran');
    }

    public function down()
    {
        $this->forge->dropTable('pengantaran');
    }
}
