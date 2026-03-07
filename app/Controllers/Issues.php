<?php

namespace App\Controllers;

use App\Models\IssueModel;

class Issues extends BaseController
{
    protected $issue;
    protected $db;

    public function __construct()
    {
        $this->issue = new IssueModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $builder = $this->db->table('issues');

        $builder->select('issues.*, projects.project_name, employees.first_name as employee_name');

        $builder->join('projects','projects.id = issues.project_id');
        $builder->join('employees','employees.id = issues.assigned_to');

        $data = [
            'title' => 'Issues',
            'issues' => $builder->get()->getResultArray()
        ];

        return view('admin/issues/index', $data);
    }

    public function show($id)
    {
        $builder = $this->db->table('issues');

        $builder->select('issues.*, projects.project_name, employees.first_name as employee_name');

        $builder->join('projects','projects.id = issues.project_id');
        $builder->join('employees','employees.id = issues.assigned_to');

        $builder->where('issues.id',$id);

        $data = [
            'title' => 'Detail Issue',
            'issue' => $builder->get()->getRowArray()
        ];

        return view('admin/issues/show', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Issue',
            'projects' => $this->db->table('projects')->get()->getResultArray(),
            'employees' => $this->db->table('employees')->get()->getResultArray()
        ];

        return view('admin/issues/create',$data);
    }

    public function store()
    {
        $this->issue->insert([

            'project_id' => $this->request->getPost('project_id'),
            'assigned_to' => $this->request->getPost('assigned_to'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 'open'

        ]);

        return redirect()->to('admin/issues')
        ->with('success','Issue berhasil dibuat');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Issue',
            'issue' => $this->issue->find($id)
        ];

        return view('admin/issues/edit',$data);
    }

    public function update($id)
    {
        $this->issue->update($id,[

            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => $this->request->getPost('status')

        ]);

        return redirect()->to('admin/issues')
        ->with('success','Issue berhasil diupdate');
    }

    public function delete($id)
    {
        $this->issue->delete($id);

        return redirect()->to('admin/issues')
        ->with('success','Issue berhasil dihapus');
    }
}