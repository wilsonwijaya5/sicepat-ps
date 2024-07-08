<?php

namespace App\Controllers\API;

use App\Models\KurirModel;
use App\Models\PengantaranModel;
use CodeIgniter\RESTful\ResourceController;

class KurirAPI extends ResourceController
{
    protected $modelName = 'App\Models\KurirModel';
    protected $format = 'json';

    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $kurir = $this->model->where('username', $username)->first();

        if (!$kurir) {
            return $this->fail('Invalid username or password', 401); // 401 Unauthorized
        }

        // Hash the incoming password
        $hashedPassword = hash('sha256', $password);

        if ($hashedPassword !== $kurir['password']) {
            return $this->fail('Invalid username or password', 401); // 401 Unauthorized
        }

        // Remove the password before returning
        unset($kurir['password']);

        return $this->respond([
            'status' => 'success',
            'message' => 'Login successful',
            'kurir' => $kurir,
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
