<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/login');
    }

   

        $requiredPermission = $arguments[0];

        if (!in_array($requiredPermission, session()->get('permissions'))) {
            return redirect()->to('/forbidden');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}