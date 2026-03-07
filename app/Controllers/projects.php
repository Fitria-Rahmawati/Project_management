<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\EmployeeModel;
use App\Models\CompanyModel;
use App\Models\ProjectMemberModel;

class Projects extends BaseController
{
    protected $projectModel;
    protected $employeeModel;
    protected $companyModel;
    protected $projectMemberModel;

    public function __construct()
    {
        $this->projectModel  = new ProjectModel();
        $this->employeeModel = new EmployeeModel();
        $this->companyModel  = new CompanyModel();
        $this->projectMemberModel = new \App\Models\ProjectMemberModel();
    }

    public function index()
    {
        return view('/admin/projects/index', [
            'title'    => 'Data Project',
            'projects' => $this->projectModel->getAllWithRelation()
        ]);
    }

    public function create()
    {
        return view('admin/projects/create', [
            'title'    => 'Tambah Project',
            'pms'      => $this->employeeModel->getProjectManagers(),
            'companies'=> $this->companyModel->findAll()
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'project_name' => 'required',
            'company_id' => 'required',
            'project_manager_id' => 'required',
            'start_date' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->projectModel->save($this->request->getPost());

        return redirect()->to('/admin/projects')->with('success', 'Project berhasil ditambahkan');
    }

   public function edit($id)
{
    $projects = $this->projectModel->find($id);

    $pms = $this->employeeModel
        ->where('company_id', $projects['company_id'])
        ->findAll();

    return view('admin/projects/edit', [
        'title'     => 'Edit Project',
        'projects'  => $projects,
        'pms'       => $pms,
        'companies' => $this->companyModel->findAll()
    ]);
}

public function getPM($company_id)
{
    $pm = $this->employeeModel
        ->where('company_id', $company_id)
        ->where('role', 'Project Manager')
        ->findAll();

    return $this->response->setJSON($pm);
}
    public function update($id)
    {
        $this->projectModel->update($id, $this->request->getPost());

        return redirect()->to('/admin/projects')->with('success', 'Project berhasil diupdate');
    }

    public function delete($id)
    {
        $this->projectModel->delete($id);

        return redirect()->to('/admin/projects')->with('success', 'Project berhasil dihapus');
    }
    public function show($id)
{
    $projects = $this->projectModel
        ->select('projects.*, companies.company_name, employees.first_name as pm_name')
        ->join('companies', 'companies.id = projects.company_id')
        ->join('employees', 'employees.id = projects.project_manager_id')
        ->where('projects.id', $id)
        ->first();

    $team = $this->projectMemberModel
        ->select('project_members.*, employees.first_name, employees.email')
        ->join('employees', 'employees.id = project_members.employee_id')
        ->where('project_members.project_id', $id)
        ->findAll();

    return view('admin/projects/show', [
        'title' => 'Detail Project',
        'projects' => $projects,
        'team' => $team
    ]);
}

    public function toggleStatus($id)
    {
        $project = $this->projectModel->find($id);
        $newStatus = $project['status'] == 'active' ? 'inactive' : 'active';
        $this->projectModel->update($id, ['status' => $newStatus]);

        return redirect()->to('/admin/projects')->with('success', 'Status project berhasil diubah');
    }
}