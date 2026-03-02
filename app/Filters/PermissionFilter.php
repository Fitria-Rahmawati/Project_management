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

    $userPermissions = session()->get('permissions') ?? [];

    foreach ($arguments as $perm) {
        if (!in_array($perm, $userPermissions)) {
            return redirect()->to('/forbidden');
        }
    }
}
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}