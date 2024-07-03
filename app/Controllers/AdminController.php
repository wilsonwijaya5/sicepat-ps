<?php

namespace App\Controllers;

use App\Models\AdminModel;

class AdminController extends BaseController
{
    public function index()
    {
        $model = new AdminModel();
        $data['admin'] = $model->findAll();
        return view('admin/index', $data);
    }

    public function create()
    {
        return view('admin/create');
    }

    public function store()
    {
        $model = new AdminModel();
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nohp' => $this->request->getPost('nohp'),
            'username' => $this->request->getPost('username'),
            'password' => hash('sha256', $this->request->getPost('password'))
        ];
        $model->save($data);
        return redirect()->to('/admin');
    }

    public function edit($id)
    {
        $model = new AdminModel();
        $data['admin'] = $model->find($id);
        return view('admin/edit', $data);
    }

    public function update($id)
    {
        $model = new AdminModel();
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nohp' => $this->request->getPost('nohp'),
            'username' => $this->request->getPost('username'),
            'password' => hash('sha256', $this->request->getPost('password'))
        ];
        $model->update($id, $data);
        return redirect()->to('/admin');
    }

    public function delete($id)
    {
        $model = new AdminModel();
        $model->delete($id);
        return redirect()->to('/admin');
    }
}
