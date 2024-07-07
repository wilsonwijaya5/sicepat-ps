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
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        if (empty($username) || empty($password)) {
            return $this->fail('Username and password are required', 400);
        }

        $kurir = $this->model->where('username', $username)->first();

        if (!$kurir || $kurir['password'] !== hash('sha256', $password)) {
            return $this->fail('Invalid username or password', 401);
        }

        // Optionally generate a token here if you are implementing token-based authentication
        return $this->respond([
            'status' => 'success',
            'message' => 'Login successful',
            'kurir' => $kurir
        ]);
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
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
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
