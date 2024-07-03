<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPengantaran extends Migration
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
            'pengantaran_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'nama_penerima' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nohp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'alamat_penerima' => [
                'type' => 'TEXT',
            ],
            'latitude' => [
                'type' => 'FLOAT',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'FLOAT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pengantaran_id', 'pengantaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_pengantaran');
    }

    public function down()
    {
        $this->forge->dropTable('detail_pengantaran');
    }
}
