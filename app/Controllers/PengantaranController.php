<?php

namespace App\Controllers;

class PengantaranController extends BaseController
{
    public function index()
    {
        return view('pengantaran/index', ['title' => 'Pengantaran']);
    }
}
