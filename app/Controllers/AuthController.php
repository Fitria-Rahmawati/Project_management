<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;        
use App\Models\EmployeeModel;    

class AuthController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $employeeModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();          
        $this->employeeModel = new EmployeeModel();  
    }

    public function login()
    {
        
        if (session()->get('isLoggedIn')) {
            return $this->redirectToDashboard(session()->get('role'));
        }
        
        return view('auth/login');
    }

    public function process()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel
            ->select('users.*, roles.name as role_name, roles.id as role_id')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.email', $email)
            ->orWhere('users.username', $email)  
            ->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email/Username tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        if ($user['is_active'] != 1) {
            return redirect()->back()->withInput()->with('error', 'Akun tidak aktif');
        }

        $permissions = $this->roleModel->getPermissions($user['role_id']);
        
        $permissionNames = [];
        foreach ($permissions as $perm) {
            $permissionNames[] = $perm['slug'];
        }

        $employee = null;
        if ($user['role_name'] == 'staff' || $user['role_name'] == 'admin') {
            $employee = $this->employeeModel
                ->select('employees.*, positions.position_name, departments.department_name')
                ->join('positions', 'positions.id = employees.position_id', 'left')
                ->join('departments', 'departments.id = employees.department_id', 'left')
                ->where('user_id', $user['id'])
                ->first();
        }


        $sessionData = [
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'email'       => $user['email'],
            'role'        => $user['role_name'],
            'role_id'     => $user['role_id'],
            'company_id'  => $user['company_id'],
            'permissions' => $permissionNames,
            'isLoggedIn'  => true
        ];

        if ($employee) {
            $sessionData['employee_id'] = $employee['id'];
            $sessionData['full_name'] = $employee['first_name'] . ' ' . $employee['last_name'];
            $sessionData['position'] = $employee['position_name'];
            $sessionData['department'] = $employee['department_name'];
        } else {
            if ($user['role_name'] == 'client') {
                $company = $this->userModel->company()->find($user['company_id']);
                $sessionData['full_name'] = $company ? $company['company_name'] : $user['username'];
            } else {
                $sessionData['full_name'] = $user['username'];
            }
        }

        session()->set($sessionData);

        return $this->redirectToDashboard($user['role_name']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

  
    private function redirectToDashboard($role)
    {
        switch ($role) {
            case 'superadmin':
                return redirect()->to('/superadmin/dashboard');
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'staff':
                return redirect()->to('/staff/dashboard');
            case 'client':
                return redirect()->to('/client/dashboard');
            default:
                return redirect()->to('/dashboard');
        }
    }
}