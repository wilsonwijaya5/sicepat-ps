<?php

namespace App\Controllers\API;

use App\Models\KurirModel;
use CodeIgniter\RESTful\ResourceController;

class KurirAPI extends ResourceController
{
    protected $modelName = 'App\Models\KurirModel';
    protected $format = 'json';

    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required' // Expecting the password to be already hashed by the client
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password'); // This should be the SHA-256 hashed password from client

        $model = new KurirModel();
        $data = $model->where('username', $username)->first();

        if ($data) {
            $stored_hashed_password = $data['password'];

            if ($password === $stored_hashed_password) {
                // Generate a response without setting session data, as it's a REST API
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'kurir' => [
                        'id' => $data['id'],
                        'username' => $data['username'],
                        'nama_lengkap' => $data['nama_lengkap'],
                        'nohp' => $data['nohp'],
                        'region' => $data['region'],
                        'no_polisi' => $data['no_polisi']
                    ],
                ]);
            } else {
                return $this->fail('Wrong Password', 401);
            }
        } else {
            return $this->failNotFound('Username not found');
        }
    }

    // Additional CRUD methods for Kurir
    public function index()
    {
        $kurirs = $this->model->findAll();
        return $this->respond($kurirs);
    }

    public function show($id = null)
    {
        $kurir = $this->model->find($id);
        if ($kurir) {
            return $this->respond($kurir);
        }
        return $this->failNotFound('Kurir not found');
    }

    public function create()
    {
        $data = $this->request->getPost();
        $data['password'] = hash('sha256', $data['password']); // Hash the password before saving
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if (isset($data['password'])) {
            $data['password'] = hash('sha256', $data['password']); // Hash the password before updating
        }
        if ($this->model->update($id, $data)) {
            return $this->respond($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->failNotFound('Kurir not found');
    }
}
?>
