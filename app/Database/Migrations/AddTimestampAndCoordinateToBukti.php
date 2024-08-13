<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampAndCoordinateToBukti extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bukti', [
            'timestamp' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'gambar'
            ],
            'coordinate' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'timestamp'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bukti', ['timestamp', 'coordinate']);
    }
}
