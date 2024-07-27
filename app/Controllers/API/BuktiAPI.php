<?php
namespace App\Controllers\API;

use App\Models\BuktiModel;
use CodeIgniter\RESTful\ResourceController;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class BuktiAPI extends ResourceController
{
    protected $modelName = 'App\Models\BuktiModel';
    protected $format    = 'json';

    public function __construct()
    {
        // Initialize Cloudinary configuration using CLOUDINARY_URL
        Configuration::instance(getenv('CLOUDINARY_URL'));
    }

    public function create()
    {
        try {
            $img = $this->request->getFile('gambar');
            log_message('info', 'Received file: ' . $img->getName());

            if (!$img->isValid()) {
                log_message('error', 'Invalid file: ' . $img->getErrorString());
                return $this->fail($img->getErrorString());
            }

            $newName = $img->getRandomName();
            $tempPath = WRITEPATH . 'uploads/' . $newName;
            log_message('info', 'Temporary path: ' . $tempPath);

            if (!$img->move(WRITEPATH . 'uploads/', $newName)) {
                log_message('error', 'Failed to move uploaded file.');
                return $this->fail('Failed to move uploaded file.');
            }

            $cloudinary = new Cloudinary();
            $uploadResult = $cloudinary->uploadApi()->upload($tempPath);
            log_message('info', 'Upload result: ' . json_encode($uploadResult));

            if (!$uploadResult) {
                log_message('error', 'Failed to upload image to Cloudinary.');
                return $this->fail('Failed to upload image to Cloudinary.');
            }

            $imageUrl = $uploadResult['secure_url'];
            log_message('info', 'Image URL: ' . $imageUrl);

            $data = [
                'tanggal_terima' => $this->request->getPost('tanggal_terima'),
                'waktu' => $this->request->getPost('waktu'),
                'keterangan' => $this->request->getPost('keterangan'),
                'gambar' => $imageUrl,
            ];

            $this->model->skipValidation(true);

            if (!$this->model->insert($data)) {
                log_message('error', 'Failed to insert data: ' . json_encode($this->model->errors()));
                return $this->fail($this->model->errors());
            }

            log_message('info', 'Data inserted successfully.');
            return $this->respondCreated(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            return $this->fail('An error occurred while processing your request.');
        }
    }    
}
