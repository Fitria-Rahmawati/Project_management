<?php

namespace App\Controllers;
use App\Models\ProjectModel;

class Projects extends BaseController
{
    protected $project;

    public function __construct()
    {
        $this->project = new ProjectModel();
    }

    public function index()
    {
        return view('projects/index', [
            'title'    => 'Daftar Proyek',
            'projects' => $this->project->findAll()
        ]);
    }

    public function create()
    {
        return view('projects/create', [
            'title' => 'Tambah Proyek'
        ]);
    }

    public function store()
    {
        $this->project->save($this->request->getPost());
        return redirect()->to('/projects');
    }

    public function edit($id)
    {
        return view('projects/edit', [
            'title'   => 'Edit Proyek',
            'project' => $this->project->find($id)
        ]);
    }

    public function update($id)
    {
        $this->project->update($id, $this->request->getPost());
        return redirect()->to('/projects');
    }

    public function delete($id)
    {
        $this->project->delete($id);
        return redirect()->to('/projects');
    }
}