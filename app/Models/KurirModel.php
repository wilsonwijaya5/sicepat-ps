<?php

namespace App\Models;

use CodeIgniter\Model;

class KurirModel extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_lengkap', 'nohp', 'username', 'password', 'region', 'no_polisi'];

    protected $useTimestamps = false; // Set to true if there are timestamp columns

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = hash('sha256', $data['data']['password']);
        }
        return $data;
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
