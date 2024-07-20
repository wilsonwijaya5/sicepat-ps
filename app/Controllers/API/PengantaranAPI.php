<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

class PengantaranAPI extends ResourceController
{
    protected $format = 'json';

    public function getPengantaranByKurir($kurirId)
    {
        $db = \Config\Database::connect();

        // Ambil data pengantaran berdasarkan kurir_id
        $pengantaranQuery = $db->table('pengantaran')
            ->where('kurir_id', $kurirId)
            ->get();

        $pengantaran = $pengantaranQuery->getResultArray();
        
        // Ambil detail pengantaran untuk setiap pengantaran
        foreach ($pengantaran as &$item) {
            $detailPengantaranQuery = $db->table('detail_pengantaran')
                ->where('pengantaran_id', $item['id'])
                ->get();

            $item['detail_pengantaran'] = $detailPengantaranQuery->getResultArray();
        }

        if ($pengantaran) {
            return $this->respond($pengantaran);
        } else {
            return $this->failNotFound('Pengantaran not found for kurir ID: ' . $kurirId);
        }
    }
}
