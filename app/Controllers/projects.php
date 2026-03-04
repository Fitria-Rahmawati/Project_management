<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\EmployeeModel;
use App\Models\CompanyModel;

class Projects extends BaseController
{
    protected $projectModel;
    protected $employeeModel;
    protected $companyModel;

    public function __construct()
    {
        $this->projectModel  = new ProjectModel();
        $this->employeeModel = new EmployeeModel();
        $this->companyModel  = new CompanyModel();
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
        return view('admin/projects/edit', [
            'title'     => 'Edit Project',
            'project'   => $this->projectModel->find($id),
            'pms'       => $this->employeeModel->getProjectManagers(),
            'companies' => $this->companyModel->findAll()
        ]);
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
}