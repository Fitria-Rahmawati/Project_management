<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployeeModel;

class ProfileController extends BaseController
{
    protected $userModel;
    protected $employeeModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->employeeModel = new EmployeeModel();
        $this->db = \Config\Database::connect();
        helper('form');
    }
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->db->table('users u')
            ->select('
                u.id,
                u.username,
                u.email,
                u.created_at,
                r.name as role_name,
                e.id as employee_id,
                e.first_name,
                e.last_name,
                e.phone,
                e.position_id,
                pos.position_name,
                e.department_id,
                d.department_name
            ')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('employees e', 'e.user_id = u.id', 'left')
            ->join('positions pos', 'pos.id = e.position_id', 'left')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->where('u.id', $userId)
            ->get()
            ->getRowArray();
        
        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data profile tidak ditemukan');
        }
        
        $data = [
            'title' => 'My Profile',
            'user' => $user
        ];
        
        return view('profile/index', $data);
    }
    public function edit()
    {
        $userId = session()->get('user_id');
        
        $user = $this->db->table('users u')
            ->select('
                u.id,
                u.username,
                u.email,
                e.id as employee_id,
                e.first_name,
                e.last_name,
                e.phone,
                e.position_id,
                e.department_id
            ')
            ->join('employees e', 'e.user_id = u.id', 'left')
            ->where('u.id', $userId)
            ->get()
            ->getRowArray();
        
        $data = [
            'title' => 'Edit Profile',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        
        return view('profile/edit', $data);
    }
    public function update()
    {
        $userId = session()->get('user_id');
        
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'permit_empty|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $employeeData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
        ];
        $employee = $this->employeeModel->where('user_id', $userId)->first();
        
        if ($employee) {
            $this->employeeModel->update($employee['id'], $employeeData);
        } else {
            $employeeData['user_id'] = $userId;
            $this->employeeModel->insert($employeeData);
        }
        $email = $this->request->getPost('email');
        if ($email && $email != session()->get('email')) {
            $this->userModel->update($userId, ['email' => $email]);
            session()->set('email', $email);
        }
        
        return redirect()->to('/profile')->with('success', 'Profile berhasil diperbarui');
    }
    public function changePassword()
    {
        $data = [
            'title' => 'Change Password'
        ];
        
        return view('profile/change_password', $data);
    }
    public function updatePassword()
    {
        $userId = session()->get('user_id');
        
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $user = $this->userModel->find($userId);
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini salah');
        }
        $this->userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
        
        return redirect()->to('/profile')->with('success', 'Password berhasil diubah');
    }
}