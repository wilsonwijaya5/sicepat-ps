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
            $gambar->move(ROOTPATH . 'public/uploads', $newName); // Save file to 'public/uploads'
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
            'timestamp' => date('Y-m-d H:i:s'), // Add current timestamp
            'coordinate' => $this->request->getVar('coordinate'), // Add coordinate
        ];

        if ($this->buktiModel->save($data)) {
            return redirect()->to('/bukti')->with('success', 'Bukti added successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to save data');
        }
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

        // Prepare data for update
        $data = [
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
            'waktu' => $this->request->getPost('waktu'),
            'keterangan' => $this->request->getPost('keterangan'),
            'timestamp' => date('Y-m-d H:i:s'), // Update timestamp
            'coordinate' => $this->request->getPost('coordinate'), // Update coordinate
        ];

        // Handle file upload
        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads', $newName);
            $data['gambar'] = 'uploads/' . $newName;

            // Delete old image if exists
            $oldImage = $this->request->getPost('gambar_lama');
            if (!empty($oldImage) && file_exists(ROOTPATH . 'public/' . $oldImage)) {
                unlink(ROOTPATH . 'public/' . $oldImage);
            }
        } else {
            // Keep the old image if no new image is uploaded
            $data['gambar'] = $this->request->getPost('gambar_lama');
        }

        // Debugging output
        log_message('debug', 'Updated Data: ' . print_r($data, true));
        log_message('debug', 'ID being updated: ' . $id);

        if ($this->buktiModel->update($id, $data)) {
            return redirect()->to('/bukti')->with('success', 'Bukti updated successfully.');
        } else {
            log_message('error', 'Update failed. Last error: ' . print_r($this->buktiModel->errors(), true));
            return redirect()->back()->withInput()->with('error', 'Failed to update data');
        }
    }

    public function delete($id)
    {
        $bukti = $this->buktiModel->find($id);

        if ($bukti) {
            // Delete image file if exists
            if (!empty($bukti['gambar']) && file_exists(ROOTPATH . 'public/' . $bukti['gambar'])) {
                unlink(ROOTPATH . 'public/' . $bukti['gambar']);
            }

            // Delete record from database
            if ($this->buktiModel->delete($id)) {
                return redirect()->to('/bukti')->with('success', 'Bukti deleted successfully.');
            } else {
                return redirect()->to('/bukti')->with('error', 'Failed to delete data');
            }
        } else {
            return redirect()->to('/bukti')->with('error', 'Bukti not found.');
        }
    }
}
