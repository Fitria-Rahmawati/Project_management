<?php

namespace App\Controllers;

use App\Models\ProjectMemberModel;
use App\Models\ProjectModel;
use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\CompanyModel;
use App\Models\PositionModel;

class ProjectMembers extends BaseController
{
    protected $member;
    protected $project;
    protected $user;
    protected $employee;
    protected $company;
    protected $position;
    protected $db;

    public function __construct()
    {
        $this->member = new ProjectMemberModel();
        $this->project = new ProjectModel();
        $this->user = new UserModel();
        $this->employee = new EmployeeModel();
        $this->company = new CompanyModel();
        $this->position = new PositionModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $builder = $this->db->table('project_members pm');

        $builder->select('
            pm.*, 
            projects.project_name,
            projects.project_type,
            users.username,
            users.email,
            users.role_id,
            roles.name as role_name,
            employees.first_name,
            employees.last_name,
            positions.position_name,
            departments.department_name,
            companies.company_name,
            companies.contact_person
        ');

        $builder->join('projects', 'projects.id = pm.project_id');
        $builder->join('users', 'users.id = pm.user_id');
        $builder->join('roles', 'roles.id = users.role_id', 'left');
        $builder->join('employees', 'employees.user_id = users.id', 'left');
        $builder->join('positions', 'positions.id = employees.position_id', 'left');
        $builder->join('departments', 'departments.id = employees.department_id', 'left');
        $builder->join('companies', 'companies.id = users.company_id', 'left');

        $data = [
            'title' => 'Manajemen Team',
            'teams' => $builder->get()->getResultArray()
        ];

        return view('admin/teams/index', $data);
    }

  public function create()
{
    $projects = $this->project
        ->select('projects.*, companies.company_name')
        ->join('companies', 'companies.id = projects.company_id', 'left')
        ->findAll();
    $users = $this->user
        ->select('users.*, roles.name as role_name')
        ->join('roles', 'roles.id = users.role_id')
        ->where('users.is_active', 1)
        ->orderBy('roles.id', 'ASC')
        ->findAll();
    $data = [
        'title' => 'Tambah Team Member',
        'projects' => $projects,
        'users' => $users,
        'positions' => $this->position->findAll(),
        'validation' => \Config\Services::validation()
    ];

    return view('admin/teams/create', $data);
}

public function store()
{
    $rules = [
        'project_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'role_in_project' => 'required|in_list[project_manager,staff,client]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Validasi gagal, periksa kembali input Anda');
    }
    $exists = $this->member
        ->where('project_id', $this->request->getPost('project_id'))
        ->where('user_id', $this->request->getPost('user_id'))
        ->first();

    if ($exists) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'User sudah terdaftar di project ini');
    }
    $user = $this->user->find($this->request->getPost('user_id'));
    $roleInProject = $this->request->getPost('role_in_project');
    if ($user['role_id'] == 3 && $roleInProject != 'client') {
        return redirect()->back()
            ->withInput()
            ->with('error', 'User dengan role Client hanya bisa ditambahkan sebagai Client');
    }
    if ($user['role_id'] == 4 && !in_array($roleInProject, ['staff', 'project_manager'])) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'User dengan role Staff hanya bisa sebagai Staff atau Project Manager');
    }
    $this->member->insert([
        'project_id' => $this->request->getPost('project_id'),
        'user_id' => $this->request->getPost('user_id'),
        'role_in_project' => $roleInProject,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    if ($roleInProject == 'staff' && $this->request->getPost('position_id')) {
        $memberId = $this->member->insertID();
        $this->db->table('project_staff_positions')->insert([
            'project_member_id' => $memberId,
            'position_id' => $this->request->getPost('position_id'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    return redirect()->to('/admin/teams')
        ->with('success', 'Team member berhasil ditambahkan');
}

    public function edit($id)
{
    $builder = $this->db->table('project_members pm');
    $builder->select('
        pm.*, 
        projects.project_name,
        projects.project_type,
        users.username,
        users.email,
        users.role_id,
        roles.name as role_name,
        employees.first_name,
        employees.last_name,
        employees.position_id
    ');
    $builder->join('projects', 'projects.id = pm.project_id');
    $builder->join('users', 'users.id = pm.user_id');
    $builder->join('roles', 'roles.id = users.role_id', 'left');
    $builder->join('employees', 'employees.user_id = users.id', 'left');
    $builder->where('pm.id', $id);
    
    $team = $builder->get()->getRowArray();
    
    if (!$team) {
        return redirect()->to('/admin/teams')
            ->with('error', 'Data tidak ditemukan');
    }
    if ($team['first_name']) {
        $team['member_name'] = $team['first_name'] . ' ' . ($team['last_name'] ?? '');
    } else {
        $team['member_name'] = $team['username'];
    }

    $data = [
        'title' => 'Edit Team Member',
        'team' => $team,
        'projects' => $this->project->findAll(),
        'users' => $this->user->findAll(),
        'positions' => $this->position->findAll(),
        'validation' => \Config\Services::validation()
    ];

    return view('admin/teams/edit', $data);
}

public function show($id)
{
    $builder = $this->db->table('project_members pm');

    $builder->select('
        pm.*, 
        projects.project_name,
        projects.project_type,
        projects.start_date,
        projects.end_date,
        users.username,
        users.email,
        users.role_id,
        roles.name as role_name,
        employees.first_name,
        employees.last_name,
        employees.phone,
        employees.hire_date,
        employees.status as employee_status,
        positions.position_name,
        departments.department_name,
        companies.company_name,
        companies.contact_person,
        companies.phone as company_phone
    ');

    $builder->join('projects', 'projects.id = pm.project_id');
    $builder->join('users', 'users.id = pm.user_id');
    $builder->join('roles', 'roles.id = users.role_id', 'left');
    $builder->join('employees', 'employees.user_id = users.id', 'left');
    $builder->join('positions', 'positions.id = employees.position_id', 'left');
    $builder->join('departments', 'departments.id = employees.department_id', 'left');
    $builder->join('companies', 'companies.id = users.company_id', 'left');
    $builder->where('pm.id', $id);

    $team = $builder->get()->getRowArray();

    if (!$team) {
        return redirect()->to('/admin/teams')
            ->with('error', 'Data tidak ditemukan');
    }
    if ($team['first_name']) {
        $team['member_name'] = $team['first_name'] . ' ' . ($team['last_name'] ?? '');
    } else {
        $team['member_name'] = $team['username'];
    }

    $data = [
        'title' => 'Detail Team Member',
        'team' => $team
    ];

    return view('admin/teams/show', $data);
}

    public function delete($id)
    {
        $team = $this->member->find($id);
        
        if (!$team) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        if ($team['role_in_project'] == 'project_manager') {
            $pmCount = $this->member
                ->where('project_id', $team['project_id'])
                ->where('role_in_project', 'project_manager')
                ->countAllResults();

            if ($pmCount <= 1) {
                return redirect()->back()
                    ->with('error', 'Tidak bisa menghapus satu-satunya Project Manager');
            }
        }

        $this->member->delete($id);

        return redirect()->to('/admin/teams')
            ->with('success', 'Team member berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $team = $this->member->find($id);

        if (!$team) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $status = ($team['status'] ?? 0) == 1 ? 0 : 1;

        $this->member->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }

    public function addMember($projectId)
    {
        $userId = $this->request->getPost('user_id');
        $role = $this->request->getPost('role_in_project');
        $exists = $this->member
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->first();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'User sudah terdaftar di project ini');
        }

        $this->member->insert([
            'project_id' => $projectId,
            'user_id' => $userId,
            'role_in_project' => $role,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()
            ->with('success', 'Member berhasil ditambahkan ke project');
    }

    public function removeMember($projectId, $userId)
    {
        $member = $this->member
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->first();

        if ($member && $member['role_in_project'] == 'project_manager') {
            $pmCount = $this->member
                ->where('project_id', $projectId)
                ->where('role_in_project', 'project_manager')
                ->countAllResults();

            if ($pmCount <= 1) {
                return redirect()->back()
                    ->with('error', 'Tidak bisa menghapus satu-satunya Project Manager');
            }
        }

        $this->db->table('project_members')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->delete();

        return redirect()->back()
            ->with('success', 'Member berhasil dihapus dari project');
    }

    public function teamProjects($id)
    {
        $builder = $this->db->table('project_members pm');

        $builder->select('
            projects.*,
            pm.role_in_project,
            users.username
        ');

        $builder->join('projects', 'projects.id = pm.project_id');
        $builder->join('users', 'users.id = pm.user_id');
        $builder->where('pm.id', $id);

        $data = [
            'title' => 'Project Member',
            'projects' => $builder->get()->getResultArray()
        ];

        return view('admin/teams/team_projects', $data);
    }

    public function projectMembers($projectId)
    {
        $builder = $this->db->table('project_members pm');

        $builder->select('
            pm.*,
            users.username,
            users.email,
            roles.name as role_name,
            employees.first_name,
            employees.last_name,
            positions.position_name,
            companies.company_name
        ');

        $builder->join('users', 'users.id = pm.user_id');
        $builder->join('roles', 'roles.id = users.role_id', 'left');
        $builder->join('employees', 'employees.user_id = users.id', 'left');
        $builder->join('positions', 'positions.id = employees.position_id', 'left');
        $builder->join('companies', 'companies.id = users.company_id', 'left');
        $builder->where('pm.project_id', $projectId);

        $data = [
            'title' => 'Project Members',
            'members' => $builder->get()->getResultArray(),
            'project_id' => $projectId
        ];

        return view('admin/teams/project_members', $data);
    }
}