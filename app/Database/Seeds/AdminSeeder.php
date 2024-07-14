<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Data to be inserted
        $data = [
            'id' => 1,
            'nama_lengkap' => 'admin',
            'nohp' => 'admin',
            'username' => 'admin',
            'password' => '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918' // MD5 hash of 'admin'
        ];

        // Using Query Builder to insert data
        $this->db->table('admin')->insert($data);
    }
}
?>