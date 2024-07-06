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
    // Define validation rules for the form inputs
    $validationRules = [
        'region' => 'required',
        'kurir_id' => 'required',
        'jumlah_paket' => 'required|numeric',
        'nama_penerima.*' => 'required',
        'nohp.*' => 'required',
        'alamat_penerima.*' => 'required',
        'tanggal_pengantaran.*' => 'required',
    ];

    // Validate the form inputs
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
        ];
    }

    // Insert batch of detail pengantaran data into database
    $this->detailPengantaranModel->insertBatch($detailData);

    // Redirect to the index page after successful insertion
    return redirect()->to('/pengantaran');
}
public function edit($id)
{
    // Fetch pengantaran data
    $pengantaran = $this->pengantaranModel->find($id);

    // Fetch related kurir data using its ID from pengantaran model
    $kurir = $this->kurirModel->find($pengantaran['kurir_id']);

    // Fetch detail pengantaran related to $id
    $detail_pengantaran = $this->detailPengantaranModel->where('pengantaran_id', $id)->findAll();

    // Fetch all kurirs (if needed for select input or other purposes)
    $kurirs = $this->kurirModel->findAll();

    // Prepare data to pass to view
    $data = [
        'pengantaran' => $pengantaran,
        'kurir' => $kurir, // Pass the fetched kurir data to the view
        'detail_pengantaran' => $detail_pengantaran,
        'kurirs' => $kurirs,
    ];

    return view('pengantaran/edit', $data);
}


    public function update($id)
    {
        $validationRules = [
            'region' => 'required',
            'kurir_id' => 'required',
            'jumlah_paket' => 'required|numeric',
            'nama_penerima.*' => 'required',
            'nohp.*' => 'required',
            'alamat_penerima.*' => 'required',
            'tanggal_pengantaran.*' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataPengantaran = [
            'region' => $this->request->getPost('region'),
            'kurir_id' => $this->request->getPost('kurir_id'),
            'jumlah_paket' => $this->request->getPost('jumlah_paket'),
        ];

        $this->pengantaranModel->update($id, $dataPengantaran);

        $namaPenerima = $this->request->getPost('nama_penerima');
        $nohp = $this->request->getPost('nohp');
        $alamatPenerima = $this->request->getPost('alamat_penerima');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $tanggalPengantaran = $this->request->getPost('tanggal_pengantaran');

        $detailData = [];
        for ($i = 0; $i < count($namaPenerima); $i++) {
            $detailData[] = [
                'pengantaran_id' => $id,
                'nama_penerima' => $namaPenerima[$i],
                'nohp' => $nohp[$i],
                'alamat_penerima' => $alamatPenerima[$i],
                'latitude' => $latitude[$i],
                'longitude' => $longitude[$i],
                'tanggal_pengantaran' => $tanggalPengantaran[$i],
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