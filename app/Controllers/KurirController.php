<?php

namespace App\Controllers;

use App\Models\KurirModel;

class KurirController extends BaseController
{
    public function index()
    {
        $model = new KurirModel();
        $data['kurir'] = $model->findAll();
        return view('kurir/index', $data);
    }

    public function create()
    {
        return view('kurir/create');
    }

    public function store()
    {
        $model = new KurirModel();
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nohp' => $this->request->getPost('nohp'),
            'username' => $this->request->getPost('username'),
            'password' => hash('sha256', $this->request->getPost('password')),
            'region' => $this->request->getPost('region'),
            'no_polisi' => $this->request->getPost('no_polisi')
        ];
        $model->save($data);
        return redirect()->to('/kurir')->with('success', 'Kurir added successfully.');
    }

    public function edit($id)
    {
        $model = new KurirModel();
        $data['kurir'] = $model->find($id);
        return view('kurir/edit', $data);
    }

    public function update($id)
    {
        $model = new KurirModel();
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nohp' => $this->request->getPost('nohp'),
            'username' => $this->request->getPost('username'),
            'password' => hash('sha256', $this->request->getPost('password')),
            'region' => $this->request->getPost('region'),
            'no_polisi' => $this->request->getPost('no_polisi')
        ];
        $model->update($id, $data);
        return redirect()->to('/kurir')->with('success', 'Kurir updated successfully.');
    }

    public function delete($id)
    {
        $model = new KurirModel();
        $model->delete($id);
        return redirect()->to('/kurir')->with('success', 'Kurir deleted successfully.');
    }
}
