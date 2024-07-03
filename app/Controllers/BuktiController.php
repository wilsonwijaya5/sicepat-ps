<?php

namespace App\Controllers;

use App\Models\BuktiModel;

class BuktiController extends BaseController
{
    protected $buktiModel;

    public function __construct()
    {
        $this->buktiModel = new BuktiModel();
    }

    public function index()
    {
        $data['title'] = 'Bukti';
        $data['bukti'] = $this->buktiModel->findAll();

        return view('bukti/index', $data);
    }

    public function create()
    {
        return view('bukti/create', ['title' => 'Create Bukti']);
    }

    public function store()
    {
        // Validate inputs
        if (!$this->validate($this->buktiModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads', $newName);
            $gambarPath = 'uploads/' . $newName;
        } else {
            $gambarPath = '';
        }

        // Save to database
        $data = [
            'tanggal_terima' => $this->request->getVar('tanggal_terima'),
            'waktu' => $this->request->getVar('waktu'),
            'keterangan' => $this->request->getVar('keterangan'),
            'gambar' => $gambarPath,
        ];

        $this->buktiModel->save($data);

        return redirect()->to('/bukti')->with('success', 'Bukti added successfully.');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Bukti';
        $data['bukti'] = $this->buktiModel->find($id);

        return view('bukti/edit', $data);
    }

    public function update($id)
    {
        // Validate inputs
        if (!$this->validate($this->buktiModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads', $newName);
            $gambarPath = 'uploads/' . $newName;
        } else {
            $gambarPath = $this->request->getVar('gambar_lama'); // Keep existing image if no new one uploaded
        }

        // Update database record
        $data = [
            'tanggal_terima' => $this->request->getVar('tanggal_terima'),
            'waktu' => $this->request->getVar('waktu'),
            'keterangan' => $this->request->getVar('keterangan'),
            'gambar' => $gambarPath,
        ];

        $this->buktiModel->update($id, $data);

        return redirect()->to('/bukti')->with('success', 'Bukti updated successfully.');
    }

    public function delete($id)
    {
        $bukti = $this->buktiModel->find($id);

        if ($bukti) {
            // Delete image file if exists
            if (!empty($bukti['gambar'])) {
                unlink(ROOTPATH . 'public/' . $bukti['gambar']);
            }

            // Delete record from database
            $this->buktiModel->delete($id);
            return redirect()->to('/bukti')->with('success', 'Bukti deleted successfully.');
        } else {
            return redirect()->to('/bukti')->with('error', 'Bukti not found.');
        }
    }
}
