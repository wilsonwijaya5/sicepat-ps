<?php

namespace App\Controllers;

use App\Models\PengantaranModel;
use App\Models\DetailPengantaranModel;
use App\Models\KurirModel;
use CodeIgniter\Controller;

class PengantaranController extends Controller
{
    protected $pengantaranModel;
    protected $detailPengantaranModel;
    protected $kurirModel;

    public function __construct()
    {
        $this->pengantaranModel = new PengantaranModel();
        $this->detailPengantaranModel = new DetailPengantaranModel();
        $this->kurirModel = new KurirModel();
    }

    public function index()
    {
        $data['pengantaran'] = $this->pengantaranModel->getAllPengantaran();
        return view('pengantaran/index', $data);
    }

    public function create()
    {
        $data['kurirs'] = $this->kurirModel->findAll();
        return view('pengantaran/create', $data);
    }

    public function store()
    {
        // Dynamic Validation Rules
        $jumlahPaket = $this->request->getPost('jumlah_paket');

        // Validate the form inputs
        $validationRules = [
            'region' => 'required',
            'kurir_id' => 'required',
            'jumlah_paket' => 'required|numeric'
        ];

        for ($i = 0; $i < $jumlahPaket; $i++) {
            $validationRules['no_resi.' . $i] = 'required';
            $validationRules['nama_penerima.' . $i] = 'required';
            $validationRules['nohp.' . $i] = 'required';
            $validationRules['alamat_penerima.' . $i] = 'required';
            $validationRules['tanggal_pengantaran.' . $i] = 'required';
            $validationRules['status.' . $i] = 'required'; 
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Retrieve the selected kurir_id from the form input
        $kurirId = $this->request->getPost('kurir_id');
    
        // Prepare data for pengantaran insertion
        $dataPengantaran = [
            'region' => $this->request->getPost('region'),
            'kurir_id' => $kurirId,
            'jumlah_paket' => $this->request->getPost('jumlah_paket'),
        ];
    
        // Insert pengantaran data into database and get the inserted ID
        $pengantaranId = $this->pengantaranModel->insert($dataPengantaran);
    
        // Prepare data for detail pengantaran insertion
        $namaPenerima = $this->request->getPost('nama_penerima');
        $nohp = $this->request->getPost('nohp');
        $alamatPenerima = $this->request->getPost('alamat_penerima');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $tanggalPengantaran = $this->request->getPost('tanggal_pengantaran');
        $noResi = $this->request->getPost('no_resi');
        $status = $this->request->getPost('status');
        $detailData = [];
    
        // Iterate through the submitted details and prepare data for insertion
        for ($i = 0; $i < count($namaPenerima); $i++) {
            $detailData[] = [
                'pengantaran_id' => $pengantaranId,
                'nama_penerima' => $namaPenerima[$i],
                'nohp' => $nohp[$i],
                'alamat_penerima' => $alamatPenerima[$i],
                'latitude' => $latitude[$i],
                'longitude' => $longitude[$i],
                'tanggal_pengantaran' => $tanggalPengantaran[$i],
                'no_resi' => $noResi[$i], 
                'status' => $status[$i],
            ];
        }
    
        // Insert batch of detail pengantaran data into database
        $this->detailPengantaranModel->insertBatch($detailData);
    
        // Redirect to the index page after successful insertion
        return redirect()->to('/pengantaran')->with('success', 'Pengantaran added successfully.');
    }

    public function edit($id)
    {
        $pengantaran = $this->pengantaranModel->find($id);
        $detail_pengantaran = $this->detailPengantaranModel->where('pengantaran_id', $id)->findAll();
        $kurirs = $this->kurirModel->findAll();

        return view('pengantaran/edit', [
            'pengantaran' => $pengantaran,
            'detail_pengantaran' => $detail_pengantaran,
            'kurirs' => $kurirs,
        ]);
    }

    public function update($id)
{
    // Validate the form inputs
    $validationRules = [
        'region' => 'required',
        'kurir_id' => 'required',
        'jumlah_paket' => 'required|numeric',
    ];

    $jumlahPaket = $this->request->getPost('jumlah_paket');
    for ($i = 0; $i < $jumlahPaket; $i++) {
        $validationRules["detail_pengantaran.${i}.tanggal_pengantaran"] = 'required';
        $validationRules["detail_pengantaran.${i}.nama_penerima"] = 'required';
        $validationRules["detail_pengantaran.${i}.nohp"] = 'required';
        $validationRules["detail_pengantaran.${i}.alamat_penerima"] = 'required';
        $validationRules["detail_pengantaran.${i}.no_resi"] = 'required';
        $validationRules["detail_pengantaran.${i}.status"] = 'required';
    }

    // Perform validation
    if (!$this->validate($validationRules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Update pengantaran data
    $dataPengantaran = [
        'region' => $this->request->getPost('region'),
        'kurir_id' => $this->request->getPost('kurir_id'),
        'jumlah_paket' => $jumlahPaket,
    ];

    // Ensure to use the primary key condition in update method
    $this->pengantaranModel->update($id, $dataPengantaran);

    // Prepare detail pengantaran data
    foreach ($this->request->getPost('detail_pengantaran') as $detail) {
        $detailId = $detail['id'];
        $detailData = [
            'nama_penerima' => $detail['nama_penerima'],
            'nohp' => $detail['nohp'],
            'alamat_penerima' => $detail['alamat_penerima'],
            'tanggal_pengantaran' => $detail['tanggal_pengantaran'],
            'no_resi' => $detail['no_resi'],
            'status' => $detail['status'],
        ];

        // Update detail pengantaran data
        $this->detailPengantaranModel->update($detailId, $detailData);
    }

    // Redirect to index page after successful update
    return redirect()->to('/pengantaran')->with('success', 'Pengantaran updated successfully.');
}
    



    public function delete($id)
    {
        // Delete pengantaran and related detail pengantaran data
        $this->pengantaranModel->delete($id);
        $this->detailPengantaranModel->where('pengantaran_id', $id)->delete();
        
        // Redirect to the index page after deletion
        return redirect()->to('/pengantaran')->with('success', 'Data deleted successfully.');
    }
}
