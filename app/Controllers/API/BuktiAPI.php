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
            'gambar' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,5048]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $img = $this->request->getFile('gambar');
        $newName = $img->getRandomName();
        $img->move(FCPATH . 'uploads', $newName);

        $data = [
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
            'waktu' => $this->request->getPost('waktu'),
            'keterangan' => $this->request->getPost('keterangan'),
            'gambar' => $newName,
        ];

        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated(['status' => 'success', 'data' => $data]);
    }
}
