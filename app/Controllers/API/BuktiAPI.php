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
        try {
            $img = $this->request->getFile('gambar');

            // Log the received file info
            log_message('info', 'Received file: ' . print_r($img, true));

            if (!$img->isValid()) {
                log_message('error', 'Invalid file upload: ' . $img->getErrorString());
                return $this->fail($img->getErrorString());
            }

            $newName = $img->getRandomName();
            $uploadPath = WRITEPATH . 'uploads/'; // Use WRITEPATH which is writable in Heroku

            // Ensure the upload directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if (!$img->move($uploadPath, $newName)) {
                log_message('error', 'Failed to move uploaded file.');
                return $this->fail('Failed to move uploaded file.');
            }

            // Log successful file move
            log_message('info', 'File moved successfully: ' . $newName);

            // Return only the filename
            $filename = $newName;

            $data = [
                'tanggal_terima' => $this->request->getPost('tanggal_terima'),
                'waktu' => $this->request->getPost('waktu'),
                'keterangan' => $this->request->getPost('keterangan'),
                'gambar' => $filename,
            ];

            // Disable validation temporarily
            $this->model->skipValidation(true);

            if (!$this->model->insert($data)) {
                log_message('error', 'Failed to insert data: ' . print_r($this->model->errors(), true));
                return $this->fail($this->model->errors());
            }

            return $this->respondCreated(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            return $this->fail('An error occurred while processing your request.');
        }
    }    
}


