<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        
        $data = [
            'username' => session('username'),
            'role'     => session('role'),
        ];

        return view('dashboard/index', $data);
    }
}