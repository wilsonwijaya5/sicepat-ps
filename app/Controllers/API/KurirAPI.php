<?php

namespace App\Controllers\API;

use App\Models\KurirModel;
use CodeIgniter\RESTful\ResourceController;

class KurirAPI extends ResourceController
{
    protected $modelName = 'App\Models\KurirModel';
    protected $format = 'json';

    // Example adjustment in KurirAPI login method for enhanced logging and error handling
    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $model = new KurirModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        log_message('debug', 'Login attempt: username = ' . $username);

        $kurir = $model->where('username', $username)->first();

        if (!$kurir) {
            log_message('debug', 'Kurir not found: ' . $username);
            return $this->failUnauthorized('Invalid username or password');
        }

        log_message('debug', 'Stored password hash: ' . $kurir['password']);

        if ($model->verifyPassword($password, $kurir['password'])) {
            log_message('debug', 'Password verified successfully for: ' . $username);

            // Jika password masih dalam format SHA-256, update ke bcrypt
            if (strlen($kurir['password']) == 64) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $model->update($kurir['id'], ['password' => $newHash]);
                log_message('debug', 'Updated password hash to bcrypt for: ' . $username);
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'Login successful',
                'kurir' => $kurir,
            ]);
        } else {
            log_message('debug', 'Password verification failed for: ' . $username);
            return $this->failUnauthorized('Invalid username or password');
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
