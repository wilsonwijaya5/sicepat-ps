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
        log_message('debug', 'Entering BuktiAPI create method.');

        $rules = [
            'tanggal_terima' => 'required|valid_date',
            'waktu' => 'required|valid_date[H:i]',
            'keterangan' => 'required',
            'gambar' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,5048]',
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return $this->fail($this->validator->getErrors());
        }

        $img = $this->request->getFile('gambar');
        $newName = $img->getRandomName();
        
        if (!$img->move(FCPATH . 'uploads', $newName)) {
            log_message('error', 'Image upload failed.');
            return $this->fail('Image upload failed.');
        }

        $data = [
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
            'waktu' => $this->request->getPost('waktu'),
            'keterangan' => $this->request->getPost('keterangan'),
            'gambar' => $newName,
        ];

        if (!$this->model->save($data)) {
            log_message('error', 'Model save failed: ' . json_encode($this->model->errors()));
            return $this->fail($this->model->errors());
        }

        log_message('debug', 'Data saved successfully: ' . json_encode($data));
        return $this->respondCreated(['status' => 'success', 'data' => $data]);
    }
}
