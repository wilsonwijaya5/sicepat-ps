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

    public function getPengantaranByKurir($kurirId)
    {
        return $this->select('pengantaran.*, kurir.nama_lengkap')
                    ->join('kurir', 'kurir.id = pengantaran.kurir_id')
                    ->where('kurir_id', $kurirId)
                    ->findAll();
    }

    public function getPengantaranWithDetailsByKurir($kurirId)
    {
        return $this->select('pengantaran.*, kurir.nama_lengkap, detail_pengantaran.*')
                    ->join('kurir', 'kurir.id = pengantaran.kurir_id')
                    ->join('detail_pengantaran', 'detail_pengantaran.pengantaran_id = pengantaran.id')
                    ->where('kurir_id', $kurirId)
                    ->findAll();
    }
}
