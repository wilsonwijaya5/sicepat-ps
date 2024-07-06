<?php

namespace App\Models;

use CodeIgniter\Model;

class PengantaranModel extends Model
{
    protected $table = 'pengantaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['region', 'kurir_id', 'jumlah_paket'];

    public function getAllPengantaran()
    {
        return $this->select('pengantaran.*, kurir.nama_lengkap')
                    ->join('kurir', 'kurir.id = pengantaran.kurir_id')
                    ->findAll();
    }
}
