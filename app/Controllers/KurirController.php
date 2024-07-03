<?php

namespace App\Controllers;

class KurirController extends BaseController
{
    public function index()
    {
        return view('kurir/index', ['title' => 'Kurir']);
    }
}
