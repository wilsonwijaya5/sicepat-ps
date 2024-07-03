<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function auth()
    {
        $session = session();
        $model = new AdminModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();
        
        if ($data) {
            $hashed_input_password = hash('sha256', $password);
            $stored_hashed_password = $data['password'];
            
            if ($hashed_input_password === $stored_hashed_password) {
                $ses_data = [
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'isLoggedIn' => true
                ];
                $session->set($ses_data);
                return redirect()->to('/home');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
