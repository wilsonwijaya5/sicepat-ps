<?php

namespace App\Models;

use CodeIgniter\Model;

class BuktiModel extends Model
{
    protected $table = 'bukti';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal_terima', 'waktu', 'keterangan', 'gambar'];

    // Optional: Validation rules for form inputs
    protected $validationRules = [
        'tanggal_terima' => 'required|valid_date',
        'waktu' => 'required|valid_time',
        'keterangan' => 'required',
        'gambar' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]'
    ];
}
