<?php

namespace App\Models;

use CodeIgniter\Model;

class PengantaranModel extends Model
{
    protected $table = 'pengantaran';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'region', 'nama_kurir', 'jumlah_paket', 'nomor_resi', 
        'nama_penerima', 'nohp', 'alamat_penerima', 
        'latitude', 'longitude', 'tanggal_pengantaran'
    ];
}
