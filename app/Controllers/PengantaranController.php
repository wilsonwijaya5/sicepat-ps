<?php

namespace App\Controllers;

use App\Models\PengantaranModel;
use App\Models\DetailPengantaranModel;
use CodeIgniter\Controller;

class PengantaranController extends Controller
{
    protected $pengantaranModel;
    protected $detailPengantaranModel;

    public function __construct()
    {
        $this->pengantaranModel = new PengantaranModel();
        $this->detailPengantaranModel = new DetailPengantaranModel();
    }

    public function index()
    {
        $data['pengantaran'] = $this->pengantaranModel->findAll();
        return view('pengantaran/index', $data);
    }

    public function create()
    {
        return view('pengantaran/create');
    }
    public function store()
    {
        $data = [
            'region' => $this->request->getPost('region'),
            'nama_kurir' => $this->request->getPost('nama_kurir'),
            'jumlah_paket' => $this->request->getPost('jumlah_paket'),
        ];
    
        $pengantaranId = $this->pengantaranModel->insert($data);
    
        $namaPenerima = $this->request->getPost('nama_penerima');
        $nohp = $this->request->getPost('nohp');
        $alamatPenerima = $this->request->getPost('alamat_penerima');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $tanggalPengantaran = $this->request->getPost('tanggal_pengantaran');
    
        $detailData = [];
        for ($i = 0; $i < count($namaPenerima); $i++) {
            $detailData[] = [
                'pengantaran_id' => $pengantaranId,
                'nama_penerima' => $namaPenerima[$i],
                'nohp' => $nohp[$i],
                'alamat_penerima' => $alamatPenerima[$i],
                'latitude' => $latitude[$i],
                'longitude' => $longitude[$i],
                'tanggal_pengantaran' => $tanggalPengantaran[$i],
            ];
        }
    
        $this->detailPengantaranModel->insertBatch($detailData);
    
        return redirect()->to('/pengantaran');
    }
    

    public function edit($id)
    {
        $pengantaran = $this->pengantaranModel->find($id);
        $detail_pengantaran = $this->detailPengantaranModel->where('pengantaran_id', $id)->findAll();

        $data = [
            'pengantaran' => $pengantaran,
            'detail_pengantaran' => $detail_pengantaran,
        ];

        return view('pengantaran/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'region' => $this->request->getPost('region'),
            'nama_kurir' => $this->request->getPost('nama_kurir'),
            'tanggal_pengantaran' => $this->request->getPost('tanggal_pengantaran'), // Menambahkan tanggal_pengantaran
        ];

        $this->pengantaranModel->update($id, $data);

        $detailData = [];
        $namaPenerima = $this->request->getPost('nama_penerima');
        $nohp = $this->request->getPost('nohp');
        $alamatPenerima = $this->request->getPost('alamat_penerima');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $tanggalPengantaran = $this->request->getPost('tanggal_pengantaran'); // Mengambil tanggal_pengantaran dari form

        for ($i = 0; $i < count($namaPenerima); $i++) {
            $detailData[] = [
                'pengantaran_id' => $id,
                'nama_penerima' => $namaPenerima[$i],
                'nohp' => $nohp[$i],
                'alamat_penerima' => $alamatPenerima[$i],
                'latitude' => $latitude[$i],
                'longitude' => $longitude[$i],
                'tanggal_pengantaran' => $tanggalPengantaran, // Menyimpan tanggal_pengantaran di setiap detail pengantaran
            ];
        }

        $this->detailPengantaranModel->where('pengantaran_id', $id)->delete();
        $this->detailPengantaranModel->insertBatch($detailData);

        return redirect()->to('/pengantaran');
    }

    public function delete($id)
    {
        $this->pengantaranModel->delete($id);
        $this->detailPengantaranModel->where('pengantaran_id', $id)->delete();
        return redirect()->to('/pengantaran');
    }
}

