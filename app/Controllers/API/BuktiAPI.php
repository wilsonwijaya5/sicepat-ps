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

    public function create()
    {
        try {
            $img = $this->request->getFile('gambar');
            if (!$img->isValid()) {
                return $this->fail($img->getErrorString());
            }

            // Configure Cloudinary
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => 'huajcm9nv',
                    'api_key'    => '174137736135129',
                    'api_secret' => 'J7N5I5RwAlr15yuJEiR7DpURH4Y',
                ],
                'url' => [
                    'secure' => true,
                ],
            ]);

            // Initialize Cloudinary
            $cloudinary = new Cloudinary();

            // Upload the image to Cloudinary
            $uploadResult = $cloudinary->uploadApi()->upload(
                $img->getTempName(),
                ['public_id' => pathinfo($img->getName(), PATHINFO_FILENAME)]
            );

            $filename = $uploadResult['public_id'] . '.' . $uploadResult['format'];

            $data = [
                'tanggal_terima' => $this->request->getPost('tanggal_terima'),
                'waktu' => $this->request->getPost('waktu'),
                'keterangan' => $this->request->getPost('keterangan'),
                'gambar' => $filename,
                'timestamp' => date('Y-m-d H:i:s'),  // Add timestamp
                'coordinate' => $this->request->getPost('coordinate'),  // Add coordinate
            ];

            // Disable validation temporarily
            $this->model->skipValidation(true);

            if (!$this->model->insert($data)) {
                return $this->fail($this->model->errors());
            }

            return $this->respondCreated(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            return $this->fail('An error occurred while processing your request.');
        }
    }
}
