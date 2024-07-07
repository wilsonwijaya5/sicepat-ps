<?php

namespace App\Controllers\API;

use App\Models\BuktiModel;
use CodeIgniter\RESTful\ResourceController;

class BuktiAPI extends ResourceController
{
    protected $modelName = 'App\Models\BuktiModel';
    protected $format = 'json';

    // List all Bukti records
    public function index()
    {
        $bukti = $this->model->findAll();
        return $this->respond($bukti);
    }

    // Show a specific Bukti record by ID
    public function show($id = null)
    {
        $bukti = $this->model->find($id);
        if ($bukti) {
            return $this->respond($bukti);
        }
        return $this->failNotFound('Bukti not found');
    }

    // Create a new Bukti record
    public function create()
    {
        $data = $this->request->getPost();
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filePath = $file->store();
            $data['gambar'] = $filePath;
        }

        if (!$this->validate($this->model->getValidationRules())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // Update a Bukti record by ID
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filePath = $file->store();
            $data['gambar'] = $filePath;
        }

        if (!$this->validate($this->model->getValidationRules())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->update($id, $data)) {
            return $this->respond($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // Delete a Bukti record by ID
    public function delete($id = null)
    {
        $bukti = $this->model->find($id);
        if ($bukti) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted(['id' => $id]);
            }
            return $this->fail('Failed to delete Bukti');
        }
        return $this->failNotFound('Bukti not found');
    }
}
