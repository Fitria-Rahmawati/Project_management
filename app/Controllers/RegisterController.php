<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\CompanyModel;
use App\Models\DepartementModel;
use App\Models\PositionModel;

class RegisterController extends BaseController
{
    protected $userModel;
    protected $employeeModel;
    protected $companyModel;
    protected $departementModel;
    protected $positionModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->employeeModel = new EmployeeModel();
        $this->companyModel = new CompanyModel();
        $this->departementModel = new DepartementModel();
        $this->positionModel = new PositionModel();
    }

    public function index()
    {
        // Ambil data untuk dropdown
        $data['departments'] = $this->departementModel->findAll();
        $data['positions'] = $this->positionModel->findAll();
        
        return view('auth/register', $data);
    }

    public function process()
    {
        // Validasi input
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'role' => 'required|in_list[staff,client]'
        ];

        // Tambah validasi sesuai role
        $role = $this->request->getPost('role');
        
        if ($role == 'staff') {
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['department_id'] = 'required|numeric';
            $rules['position_id'] = 'required|numeric';
            $rules['phone'] = 'permit_empty|numeric';
        } else { // client
            $rules['company_name'] = 'required';
            $rules['contact_person'] = 'required';
            $rules['company_email'] = 'required|valid_email';
            $rules['company_phone'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal');
        }

        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. INSERT ke tabel users
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Set role_id berdasarkan role
            if ($role == 'staff') {
                $userData['role_id'] = 4; // staff
                $userData['company_id'] = 1; // internal company
            } else {
                $userData['role_id'] = 3; // client
                // company_id akan diisi setelah buat company
            }

            $this->userModel->insert($userData);
            $userId = $this->userModel->insertID();

            // 2. INSERT data tambahan sesuai role
            if ($role == 'staff') {
                // INSERT ke employees
                $employeeData = [
                    'user_id' => $userId,
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'position_id' => $this->request->getPost('position_id'),
                    'department_id' => $this->request->getPost('department_id'),
                    'company_id' => 1, // internal
                    'hire_date' => $this->request->getPost('hire_date') ?: date('Y-m-d'),
                    'status' => 'permanent',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->employeeModel->insert($employeeData);
                
            } else {
                // INSERT ke companies (untuk client)
                $companyData = [
                    'company_name' => $this->request->getPost('company_name'),
                    'company_type' => 'client',
                    'contact_person' => $this->request->getPost('contact_person'),
                    'email' => $this->request->getPost('company_email'),
                    'phone' => $this->request->getPost('company_phone'),
                    'address' => $this->request->getPost('company_address'),
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->companyModel->insert($companyData);
                $companyId = $this->companyModel->insertID();

                // Update user dengan company_id
                $this->userModel->update($userId, ['company_id' => $companyId]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Gagal mendaftar, silakan coba lagi');
            }

            return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}