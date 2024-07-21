<?php
namespace App\Models;

use CodeIgniter\Model;

class BuktiModel extends Model
{
    protected $table = 'bukti';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal_terima', 'waktu', 'keterangan', 'gambar'];
}
