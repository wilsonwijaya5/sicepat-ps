<?php

namespace App\Controllers;

use App\Models\PengantaranModel;
use CodeIgniter\Controller;

class PengantaranController extends Controller
{
    public function index()
    {
        $model = new PengantaranModel();
        $data['pengantaran'] = $model->findAll();
        return view('pengantaran/index', $data);
    }

    public function create()
    {
        return view('pengantaran/create');
    }

    public function store()
    {
        $model = new PengantaranModel();

        if ($this->request->getMethod() === 'post' && $this->validate([
            'region' => 'required',
            'nama_kurir' => 'required',
            'jumlah_paket' => 'required|integer',
            'nomor_resi' => 'required',
            'nama_penerima' => 'required',
            'nohp' => 'required',
            'alamat_penerima' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'tanggal_pengantaran' => 'required|valid_date',
        ])) {
            $model->save([
                'region' => $this->request->getPost('region'),
                'nama_kurir' => $this->request->getPost('nama_kurir'),
                'jumlah_paket' => $this->request->getPost('jumlah_paket'),
                'nomor_resi' => $this->request->getPost('nomor_resi'),
                'nama_penerima' => $this->request->getPost('nama_penerima'),
                'nohp' => $this->request->getPost('nohp'),
                'alamat_penerima' => $this->request->getPost('alamat_penerima'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'tanggal_pengantaran' => $this->request->getPost('tanggal_pengantaran'),
            ]);

            return redirect()->to('/pengantaran');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($id)
    {
        $model = new PengantaranModel();
        $data['pengantaran'] = $model->find($id);
        return view('pengantaran/edit', $data);
    }

    public function update($id)
    {
        $model = new PengantaranModel();

        if ($this->request->getMethod() === 'post' && $this->validate([
            'region' => 'required',
            'nama_kurir' => 'required',
            'jumlah_paket' => 'required|integer',
            'nomor_resi' => 'required',
            'nama_penerima' => 'required',
            'nohp' => 'required',
            'alamat_penerima' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'tanggal_pengantaran' => 'required|valid_date',
        ])) {
            $model->update($id, [
                'region' => $this->request->getPost('region'),
                'nama_kurir' => $this->request->getPost('nama_kurir'),
                'jumlah_paket' => $this->request->getPost('jumlah_paket'),
                'nomor_resi' => $this->request->getPost('nomor_resi'),
                'nama_penerima' => $this->request->getPost('nama_penerima'),
                'nohp' => $this->request->getPost('nohp'),
                'alamat_penerima' => $this->request->getPost('alamat_penerima'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'tanggal_pengantaran' => $this->request->getPost('tanggal_pengantaran'),
            ]);

            return redirect()->to('/pengantaran');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        $model = new PengantaranModel();
        $model->delete($id);
        return redirect()->to('/pengantaran');
    }
}
