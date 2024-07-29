<?php

namespace App\Models;

use CodeIgniter\Model;

class KurirModel extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_lengkap', 'nohp', 'username', 'password', 'region', 'no_polisi'];

    public function verifyPassword($inputPassword, $storedPassword)
    {
        if (strlen($storedPassword) == 64) {
            // Ini adalah hash SHA-256 lama
            return hash('sha256', $inputPassword) === $storedPassword;
        } else {
            // Ini adalah hash bcrypt baru
            return password_verify($inputPassword, $storedPassword);
        }
    }
    public function getKurirsByRegion($region)
    {
        return $this->where('region', $region)->findAll();
    }
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
