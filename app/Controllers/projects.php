<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\EmployeeModel;
use App\Models\CompanyModel;
use App\Models\ProjectMemberModel;
use App\Models\UserModel;

class Projects extends BaseController
{
    protected $projectModel;
    protected $employeeModel;
    protected $companyModel;
    protected $projectMemberModel;
    protected $userModel;

    public function __construct()
    {
        $this->projectModel  = new ProjectModel();
        $this->employeeModel = new EmployeeModel();
        $this->companyModel  = new CompanyModel();
        $this->projectMemberModel = new ProjectMemberModel();
        $this->userModel = new UserModel();
        helper('text');
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        $company = $this->request->getGet('company');

        $projects = $this->projectModel->getAllWithRelation($status, $type, $company);

        $companies = $this->companyModel->where('company_type', 'client')->findAll();

        return view('admin/projects/index', [
            'title'     => 'Data Project',
            'projects'  => $projects,
            'companies' => $companies,
            'filters'   => [
                'status' => $status,
                'type'   => $type,
                'company' => $company
            ]
        ]);
    }

    public function create()
    {
        $pms = $this->userModel
            ->select('users.*, employees.first_name, employees.last_name')
            ->join('employees', 'employees.user_id = users.id', 'left')
            ->whereIn('users.role_id', [1, 2]) 
            ->where('users.is_active', 1)
            ->findAll();

        $companies = $this->companyModel->findAll();

        return view('admin/projects/create', [
            'title'     => 'Tambah Project',
            'pms'       => $pms,
            'companies' => $companies
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'project_name' => 'required|min_length[3]|max_length[255]',
            'company_id'   => 'required|numeric',
            'project_manager_id' => 'required|numeric',
            'start_date'   => 'required|valid_date',
            'end_date'     => 'permit_empty|valid_date',
            'project_type' => 'required|in_list[internal,client]',
            'status'       => 'required|in_list[planning,in_progress,completed,cancelled]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'project_name' => $this->request->getPost('project_name'),
            'description'  => $this->request->getPost('description'),
            'company_id'   => $this->request->getPost('company_id'),
            'project_manager_id' => $this->request->getPost('project_manager_id'),
            'project_type' => $this->request->getPost('project_type'),
            'start_date'   => $this->request->getPost('start_date'),
            'end_date'     => $this->request->getPost('end_date') ?: null,
            'status'       => $this->request->getPost('status'),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        $this->projectModel->save($data);

        return redirect()->to('/admin/projects')->with('success', 'Project berhasil ditambahkan');
    }

    public function edit($id)
    {
        $project = $this->projectModel->find($id);

        if (!$project) {
            return redirect()->to('/admin/projects')->with('error', 'Project tidak ditemukan');
        }
        $pms = $this->userModel
            ->select('users.*, employees.first_name, employees.last_name, employees.position_id')
            ->join('employees', 'employees.user_id = users.id', 'left')
            ->whereIn('users.role_id', [1, 2]) 
            ->where('users.company_id', $project['company_id'])
            ->where('users.is_active', 1)
            ->findAll();

        $companies = $this->companyModel->findAll();

        return view('admin/projects/edit', [
            'title'     => 'Edit Project',
            'project'   => $project,
            'pms'       => $pms,
            'companies' => $companies
        ]);
    }

    public function getPM($company_id)
    {
        $pms = $this->userModel
            ->select('users.id, users.username, employees.first_name, employees.last_name')
            ->join('employees', 'employees.user_id = users.id', 'left')
            ->whereIn('users.role_id', [1, 2]) 
            ->where('users.company_id', $company_id)
            ->where('users.is_active', 1)
            ->findAll();

        return $this->response->setJSON($pms);
    }

    public function update($id)
    {
        $project = $this->projectModel->find($id);

        if (!$project) {
            return redirect()->to('/admin/projects')->with('error', 'Project tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        $validation->setRules([
            'project_name' => 'required|min_length[3]|max_length[255]',
            'company_id'   => 'required|numeric',
            'project_manager_id' => 'required|numeric',
            'start_date'   => 'required|valid_date',
            'end_date'     => 'permit_empty|valid_date',
            'status'       => 'required|in_list[planning,in_progress,completed,cancelled]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'project_name' => $this->request->getPost('project_name'),
            'description'  => $this->request->getPost('description'),
            'company_id'   => $this->request->getPost('company_id'),
            'project_manager_id' => $this->request->getPost('project_manager_id'),
            'start_date'   => $this->request->getPost('start_date'),
            'end_date'     => $this->request->getPost('end_date') ?: null,
            'status'       => $this->request->getPost('status'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        if ($project['project_type'] != $this->request->getPost('project_type')) {
            return redirect()->back()->withInput()->with('error', 'Project type tidak dapat diubah');
        }

        $this->projectModel->update($id, $data);

        return redirect()->to('/admin/projects')->with('success', 'Project berhasil diupdate');
    }

    public function delete($id)
    {
        $project = $this->projectModel->find($id);

        if (!$project) {
            return redirect()->to('/admin/projects')->with('error', 'Project tidak ditemukan');
        }
        $db = \Config\Database::connect();
        $issueCount = $db->table('issues')->where('project_id', $id)->countAllResults();

        if ($issueCount > 0) {
            return redirect()->to('/admin/projects')
                ->with('error', 'Tidak dapat menghapus project yang memiliki issues');
        }
        $db->table('project_members')->where('project_id', $id)->delete();
        $this->projectModel->delete($id);

        return redirect()->to('/admin/projects')->with('success', 'Project berhasil dihapus');
    }

    public function show($id)
    {
        $project = $this->projectModel
            ->select('
                projects.*,
                companies.company_name,
                companies.company_type,
                companies.contact_person,
                companies.phone as company_phone,
                manager.username as manager_username,
                employees.first_name as manager_first_name,
                employees.last_name as manager_last_name
            ')
            ->join('companies', 'companies.id = projects.company_id', 'left')
            ->join('users manager', 'manager.id = projects.project_manager_id', 'left')
            ->join('employees', 'employees.user_id = manager.id', 'left')
            ->where('projects.id', $id)
            ->first();

        if (!$project) {
            return redirect()->to('/admin/projects')->with('error', 'Project tidak ditemukan');
        }
        $team = $this->projectMemberModel
            ->select('
                project_members.*,
                users.username,
                users.email,
                employees.first_name,
                employees.last_name,
                positions.position_name,
                departments.department_name
            ')
            ->join('users', 'users.id = project_members.user_id')
            ->join('employees', 'employees.user_id = users.id', 'left')
            ->join('positions', 'positions.id = employees.position_id', 'left')
            ->join('departments', 'departments.id = employees.department_id', 'left')
            ->where('project_members.project_id', $id)
            ->findAll();
        $db = \Config\Database::connect();
        $issueStats = $db->table('issues')
            ->select('status, COUNT(*) as total')
            ->where('project_id', $id)
            ->groupBy('status')
            ->get()
            ->getResultArray();

        return view('admin/projects/show', [
            'title'     => 'Detail Project: ' . $project['project_name'],
            'project'   => $project,
            'team'      => $team,
            'issueStats' => $issueStats
        ]);
    }

    public function toggleStatus($id)
    {
        $project = $this->projectModel->find($id);

        if (!$project) {
            return redirect()->to('/admin/projects')->with('error', 'Project tidak ditemukan');
        }

        $newStatus = $project['is_active'] == 1 ? 0 : 1;

        $this->projectModel->update($id, ['is_active' => $newStatus]);

        $message = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/admin/projects')->with('success', "Project berhasil $message");
    }

    public function statistics()
    {
        $db = \Config\Database::connect();

        $total = $this->projectModel->countAll();
        $byStatus = $db->table('projects')
            ->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->getResultArray();
        $byType = $db->table('projects')
            ->select('project_type, COUNT(*) as total')
            ->groupBy('project_type')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'total' => $total,
            'by_status' => $byStatus,
            'by_type' => $byType
        ]);
    }
}