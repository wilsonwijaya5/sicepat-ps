<?php

namespace App\Controllers\API;

use App\Models\AdminModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait; // Add this line

class AdminAPI extends ResourceController
{
    use ResponseTrait; // Use the ResponseTrait for standardized responses

    protected $modelName = 'App\Models\AdminModel';
    protected $format = 'json';

    // GET - Retrieve all admins
    public function index()
    {
        $admins = $this->model->findAll();
        return $this->respond($admins);
    }

    // GET - Retrieve a specific admin by ID
    public function show($id = null)
    {
        $admin = $this->model->find($id);
        if (!$admin) {
            return $this->failNotFound('Admin not found');
        }
        return $this->respond($admin);
    }

    // POST - Create a new admin
    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_lengkap' => 'required',
            'nohp' => 'required|numeric', 
            'username' => 'required|is_unique[admin.username]',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors()); 
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nohp' => $this->request->getPost('nohp'),
            'username' => $this->request->getPost('username'),
            'password' => hash('sha256', $this->request->getPost('password')),
        ];

        $this->model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Admin created successfully'
            ]
        ];
        return $this->respondCreated($response);
    }

    public function update($id = null)
    {
        if (!$id) {
            return $this->fail('ID cannot be null');
        }

        $admin = $this->model->find($id);
        if (!$admin) {
            return $this->failNotFound('Admin not found');
        }

        $input = $this->request->getRawInput();

        $rules = [
            'nama_lengkap' => 'required',
            'nohp' => 'required|numeric',
            'username' => 'required'
        ];

        // Check if username is unique, excluding the current admin
        if (isset($input['username']) && $input['username'] !== $admin['username']) {
            $rules['username'] .= '|is_unique[admin.username]';
        }

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Hash password only if it's provided in the update
        if (isset($input['password'])) {
            $input['password'] = hash('sha256', $input['password']);
        }

        $this->model->update($id, $input);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Admin updated successfully'
            ]
        ];
        return $this->respond($response);
    }
    // DELETE - Delete an admin by ID
    public function delete($id = null)
    {
        $admin = $this->model->find($id);
        if ($admin) {
            $this->model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Admin deleted successfully'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Admin not found');
        }
    }
}
