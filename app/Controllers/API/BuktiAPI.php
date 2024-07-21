<?php
namespace App\Controllers\API;

use App\Models\BuktiModel;
use CodeIgniter\RESTful\ResourceController;

class BuktiAPI extends ResourceController
{
    protected $modelName = 'App\Models\BuktiModel';
    protected $format    = 'json';

    public function create()
    {
        helper(['form', 'url']);

        $rules = [
            'tanggal_terima' => 'required|valid_date',
            'waktu' => 'required|valid_date[H:i]',
            'keterangan' => 'required',
            'gambar' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $img = $this->request->getFile('gambar');
        $newName = $img->getRandomName();
        $img->move(WRITEPATH . 'uploads', $newName);

        $data = [
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
            'waktu' => date('H:i'),
            'keterangan' => $this->request->getPost('keterangan'),
            'gambar' => $newName,
        ];

        if (!$this->model->save($data)) {
            return $this->fail('Failed to save data');
        }

        return $this->respondCreated(['status' => 'success', 'data' => $data]);
    }
}
