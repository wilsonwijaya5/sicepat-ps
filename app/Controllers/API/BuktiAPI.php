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
            helper(['form', 'url']);
            
            // Check if file is uploaded
            $img = $this->request->getFile('gambar');
            if (!$img) {
                return $this->fail('No image file uploaded.');
            }
            
            log_message('debug', 'File upload: ' . $img->getName());

            // Validate file
            if (!$img->isValid()) {
                log_message('error', 'File upload error: ' . $img->getErrorString());
                return $this->fail($img->getErrorString());
            }

            // Generate a new name and move the file
            $newName = $img->getRandomName();
            $uploadPath = WRITEPATH . 'uploads/';

            // Ensure the upload directory exists
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0755, true)) {
                    log_message('error', 'Failed to create upload directory: ' . $uploadPath);
                    return $this->fail('Failed to create upload directory.');
                }
            }

            if (!$img->move($uploadPath, $newName)) {
                log_message('error', 'Failed to move uploaded file.');
                return $this->fail('Failed to move uploaded file.');
            }

            log_message('debug', 'File moved successfully to: ' . $uploadPath . $newName);

            $data = [
                'tanggal_terima' => $this->request->getPost('tanggal_terima'),
                'waktu' => $this->request->getPost('waktu'),
                'keterangan' => $this->request->getPost('keterangan'),
                'gambar' => $newName,
            ];

            // Skip validation for now (if necessary)
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
