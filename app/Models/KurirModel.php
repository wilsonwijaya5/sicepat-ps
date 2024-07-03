<?php

namespace App\Models;

use CodeIgniter\Model;

class KurirModel extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_lengkap', 'nohp', 'username', 'password', 'region', 'no_polisi'];

    protected $useTimestamps = false; // Ubah menjadi true jika ada kolom timestamp di tabel

    public function getAllKurir()
    {
        return $this->findAll();
    }

    public function saveKurir($data)
    {
        return $this->insert($data);
    }

    public function getKurir($id)
    {
        return $this->find($id);
    }

    public function updateKurir($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteKurir($id)
    {
        return $this->delete($id);
    }
}
