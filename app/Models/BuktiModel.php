<?php
namespace App\Models;

use CodeIgniter\Model;

class BuktiModel extends Model
{
    protected $table = 'bukti';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal_terima', 'waktu', 'keterangan', 'gambar'];
    protected $validationRules = [
        'tanggal_terima' => 'required|valid_date',
        'waktu' => 'required',
        'keterangan' => 'required',
        'gambar' => 'permit_empty|is_image[gambar]'
    ];
}