<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPengantaranModel extends Model
{
    protected $table = 'detail_pengantaran';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pengantaran_id', 'nama_penerima', 'nohp', 'alamat_penerima', 'latitude', 'longitude','tanggal_pengantaran'
    ];

    // Tambahan metode atau pengaturan lain sesuai kebutuhan aplikasi
}
