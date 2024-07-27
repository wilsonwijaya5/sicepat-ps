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
    
            if (!$img->isValid()) {
                return $this->fail($img->getErrorString());
            }
    
            $newName = $img->getRandomName();
            $uploadPath = '/tmp/uploads/'; // Use /tmp directory for uploads
    
            // Ensure the upload directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
    
            if (!$img->move($uploadPath, $newName)) {
                log_message('error', 'Failed to move uploaded file.');
                return $this->fail('Failed to move uploaded file.');
            }
    
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
                log_message('error', 'Failed to insert data into the database: ' . print_r($this->model->errors(), true));
                return $this->fail($this->model->errors());
            }
    
            return $this->respondCreated(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            return $this->fail('An error occurred while processing your request.');
        }
    }    
}

