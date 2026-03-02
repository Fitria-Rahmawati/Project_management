<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RolePermissionModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function process()
    {
        $userModel = new UserModel();
        $rolePermissionModel = new RolePermissionModel();

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->getUserWithRole($email);

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        if ($user['is_active'] != 1) {
            return redirect()->back()->with('error', 'Akun tidak aktif');
        }
        $permissions = $rolePermissionModel->getPermissionsByRole($user['role_id']);
        $permissionSlugs = array_column($permissions, 'slug');
        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role_name'],
            'role_id'    => $user['role_id'],
            'company_id' => $user['company_id'],
            'permissions' => $permissionSlugs,
            'isLoggedIn' => true
        ]);
         
        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}