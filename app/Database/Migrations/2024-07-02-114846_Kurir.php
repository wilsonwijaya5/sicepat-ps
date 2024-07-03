<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kurir extends Migration
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
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nohp' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'region' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'no_polisi' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kurir');
    }

    public function down()
    {
        $this->forge->dropTable('kurir');
    }
}
