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
            'nomor_resi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nama_penerima' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nohp' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'alamat_penerima' => [
                'type' => 'TEXT',
            ],
            'latitude' => [
                'type' => 'DOUBLE',
            ],
            'longitude' => [
                'type' => 'DOUBLE',
            ],
            'tanggal_pengantaran' => [
                'type' => 'DATE',
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
