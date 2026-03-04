<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RolePermissionModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $rolePermissionModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function process()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // =========================
        // AMBIL USER + ROLE
        // =========================
        $user = $this->userModel->getUserWithRole($email);

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        if ($user['is_active'] != 1) {
            return redirect()->back()->with('error', 'Akun tidak aktif');
        }

        // =========================
        // AMBIL PERMISSION BERDASARKAN ROLE
        // =========================
        $permissions = $this->rolePermissionModel
            ->getPermissionsByRole($user['role_id']);

        // PENTING: pakai kolom "slug"
        $permissionNames = array_column($permissions, 'slug');

        // =========================
        // SET SESSION
        // =========================
        session()->set([
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'email'       => $user['email'],
            'role'        => $user['role_name'],
            'role_id'     => $user['role_id'],
            'company_id'  => $user['company_id'],
            'permissions' => $permissionNames,
            'isLoggedIn'  => true
        ]);

        // =========================
        // REDIRECT BERDASARKAN ROLE
        // =========================
        switch ($user['role_name']) {
            case 'superadmin':
                return redirect()->to('/superadmin/dashboard');
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'client':
                return redirect()->to('/client/dashboard');
            case 'staff':
                return redirect()->to('/staff/dashboard');
            default:
                return redirect()->to('/dashboard');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}