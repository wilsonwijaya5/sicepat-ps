<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PengantaranModel;
use App\Models\DetailPengantaranModel;

class RuteAPI extends ResourceController
{
    protected $format = 'json';

    public function optimizeRoute($kurirId)
    {
        $startLat = $this->request->getGet('start_lat');
        $startLon = $this->request->getGet('start_lon');

        if (!$startLat || !$startLon) {
            return $this->fail('Start latitude and longitude are required', 400);
        }

        $pengantaranModel = new PengantaranModel();
        $detailPengantaranModel = new DetailPengantaranModel();

        // Ambil data pengantaran dengan status pending
        $pengantaran = $detailPengantaranModel->getPendingDetailsByKurir($kurirId);

        if (empty($pengantaran)) {
            return $this->failNotFound('No pending pengantaran found for kurir ID: ' . $kurirId);
        }

        // Tambahkan posisi awal kurir ke daftar koordinat
        $coordinates = [
            [
                'id' => 'start',
                'lat' => $startLat,
                'lon' => $startLon,
                'nama_penerima' => 'Kurir Start Position',
                'alamat_penerima' => 'Current Location'
            ]
        ];

        // Tambahkan koordinat dari detail pengantaran dengan status pending
        foreach ($pengantaran as $item) {
            $coordinates[] = [
                'id' => $item['id'],
                'lat' => $item['latitude'],
                'lon' => $item['longitude'],
                'nama_penerima' => $item['nama_penerima'],
                'alamat_penerima' => $item['alamat_penerima']
            ];
        }

        // Hitung jarak menggunakan Formula Haversine
        $distances = $this->calculateDistances($coordinates);

        // Terapkan algoritma Dijkstra untuk menentukan rute optimal
        $optimalRoute = $this->dijkstra($distances);

        // Susun hasil rute optimal
        $result = [];
        foreach ($optimalRoute as $index) {
            $result[] = $coordinates[$index];
        }

        // Hitung total jarak
        $totalDistance = $this->calculateTotalDistance($optimalRoute, $distances);

        return $this->respond([
            'optimal_route' => $result,
            'total_distance' => $totalDistance
        ]);
    }

    private function calculateDistances($coordinates)
    {
        $distances = [];
        $n = count($coordinates);

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i != $j) {
                    $distances[$i][$j] = $this->haversine(
                        $coordinates[$i]['lat'],
                        $coordinates[$i]['lon'],
                        $coordinates[$j]['lat'],
                        $coordinates[$j]['lon']
                    );
                } else {
                    $distances[$i][$j] = 0;
                }
            }
        }

        return $distances;
    }

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function dijkstra($graph)
    {
        $n = count($graph);
        $visited = array_fill(0, $n, false);
        $distance = array_fill(0, $n, PHP_INT_MAX);
        $parent = array_fill(0, $n, -1);

        $distance[0] = 0;

        for ($i = 0; $i < $n - 1; $i++) {
            $u = $this->minDistance($distance, $visited);
            $visited[$u] = true;

            for ($v = 0; $v < $n; $v++) {
                if (!$visited[$v] && $graph[$u][$v] && $distance[$u] != PHP_INT_MAX
                    && $distance[$u] + $graph[$u][$v] < $distance[$v]) {
                    $distance[$v] = $distance[$u] + $graph[$u][$v];
                    $parent[$v] = $u;
                }
            }
        }

        return $this->reconstructPath($parent);
    }

    private function minDistance($distance, $visited)
    {
        $min = PHP_INT_MAX;
        $minIndex = -1;

        foreach ($distance as $i => $dist) {
            if (!$visited[$i] && $dist <= $min) {
                $min = $dist;
                $minIndex = $i;
            }
        }

        return $minIndex;
    }

    private function reconstructPath($parent)
    {
        $path = [];
        $v = count($parent) - 1;

        while ($v != -1) {
            array_unshift($path, $v);
            $v = $parent[$v];
        }

        return $path;
    }

    private function calculateTotalDistance($route, $distances)
    {
        $totalDistance = 0;
        for ($i = 0; $i < count($route) - 1; $i++) {
            $totalDistance += $distances[$route[$i]][$route[$i + 1]];
        }
        return $totalDistance;
    }
}
