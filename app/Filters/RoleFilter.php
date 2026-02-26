<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $roles = null)
    {
        // belum login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // role user sekarang
        $userRole = session('role');

        // kalau role tidak sesuai
        if ($roles && !in_array($userRole, $roles)) {
            return redirect()->to('/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 
    }
}