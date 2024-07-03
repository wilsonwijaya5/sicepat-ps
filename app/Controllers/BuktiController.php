<?php

namespace App\Controllers;

class BuktiController extends BaseController
{
    public function index()
    {
        return view('bukti/index', ['title' => 'Bukti']);
    }
}
