<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\UserModel;
use App\Models\ProjectModel;
use App\Models\RoleModel;
use App\Models\EmployeeModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session('role');

        $data = [
            'username' => session('username'),
            'role'     => $role,
        ];

        // Ambil data sesuai role
        switch ($role) {
            case 'superadmin':
                $companyModel = new CompanyModel();
                $userModel    = new UserModel();
                $projectModel = new ProjectModel();
                $roleModel    = new RoleModel();

                $data['totalCompanies'] = $companyModel->countAllResults();
                $data['totalUsers']     = $userModel->countAllResults();
                $data['activeUsers']    = $userModel->where('is_active', 1)->countAllResults();
                $data['inactiveUsers']  = $userModel->where('is_active', 0)->countAllResults();
                $data['totalProjects']  = $projectModel->countAllResults();
                $data['totalRoles']     = $roleModel->countAllResults();
                break;

            case 'admin':
                $projectModel = new ProjectModel();
                $employeeModel = new EmployeeModel();

                $data['totalProjects'] = $projectModel->countAllResults();
                $data['totalEmployees'] = $employeeModel->countAllResults();
                $data['activeEmployees'] = $employeeModel->where('status', 'permanent')->countAllResults();
                $data['inProgressProjects'] = $projectModel->where('status', 'in_progress')->countAllResults();
                break;

            case 'staff':
                $employeeModel = new EmployeeModel();

                $data['myTasks'] = $employeeModel->countAllResults(); // bisa diganti query khusus staff
                $data['myProjects'] = 5; // contoh placeholder
                $data['pendingIssues'] = 2;
                break;

            case 'client':
                $projectModel = new ProjectModel();

                $data['myProjects'] = $projectModel->where('company_id', session('company_id'))->countAllResults();
                $data['ongoingProjects'] = $projectModel->where('company_id', session('company_id'))->where('status', 'in_progress')->countAllResults();
                break;
        }

        return view('dashboard/index', $data);
    }
}