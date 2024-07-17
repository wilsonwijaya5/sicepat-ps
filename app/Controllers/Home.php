<?php

namespace App\Controllers;

use App\Models\DetailPengantaranModel; // Tambahkan ini

class Home extends BaseController
{
    public function index()
    {
        $detailPengantaranModel = new DetailPengantaranModel();

        // Mendapatkan jumlah pengantaran berdasarkan status
        $pendingCount = $detailPengantaranModel->getCountByStatus('pending');
        $onDeliveryCount = $detailPengantaranModel->getCountByStatus('on delivery');
        $deliveredCount = $detailPengantaranModel->getCountByStatus('delivered');
        $failedCount = $detailPengantaranModel->getCountByStatus('failed');

        // Mengirim data ke view
        $data = [
            'pendingCount' => $pendingCount,
            'onDeliveryCount' => $onDeliveryCount,
            'deliveredCount' => $deliveredCount,
            'failedCount' => $failedCount,
        ];
        return view('home/index', $data); // Mengirimkan data ke view
    }
}
