<?php

namespace App\Controllers;

use App\Models\ProjectMemberModel;

class ProjectMembers extends BaseController
{
    protected $member;
    protected $db;

    public function __construct()
    {
        $this->member = new ProjectMemberModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $builder = $this->db->table('project_members pm');

        $builder->select('pm.*, projects.project_name,
                          employees.first_name as employee_name,
                          positions.position_name as position_name');

        $builder->join('projects','projects.id = pm.project_id');
        $builder->join('employees','employees.id = pm.employee_id');
        $builder->join('positions','positions.id = pm.position_id');

        $data = [
            'title' => 'Teams',
            'teams' => $builder->get()->getResultArray()
        ];

        return view('/admin/teams/index',$data);
    }

    public function show($id)
    {
        $builder = $this->db->table('project_members pm');

        $builder->select('pm.*, projects.project_name,
                          employees.first_name as employee_name,
                          positions.position_name as position_name');

        $builder->join('projects','projects.id = pm.project_id');
        $builder->join('employees','employees.id = pm.employee_id');
        $builder->join('positions','positions.id = pm.position_id');

        $builder->where('pm.id',$id);

        $data = [
            'title' => 'Detail Team',
            'team' => $builder->get()->getRowArray()
        ];

        return view('/admin/teams/show',$data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Team',
            'projects' => $this->db->table('projects')->get()->getResultArray(),
            'employees' => $this->db->table('employees')->get()->getResultArray(),
            'positions' => $this->db->table('positions')->get()->getResultArray()
        ];

        return view('/admin/teams/create',$data);
    }

    public function store()
    {
        $this->member->insert([
            'project_id' => $this->request->getPost('project_id'),
            'employee_id' => $this->request->getPost('employee_id'),
            'position_id' => $this->request->getPost('position_id')
        ]);

        return redirect()->to('/admin/teams')
            ->with('success','Team berhasil dibuat');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Team',
            'team' => $this->member->find($id),
            'projects' => $this->db->table('projects')->get()->getResultArray(),
            'employees' => $this->db->table('employees')->get()->getResultArray(),
            'positions' => $this->db->table('positions')->get()->getResultArray()
        ];

        return view('/admin/teams/edit',$data);
    }

    public function update($id)
    {
        $this->member->update($id,[
            'project_id' => $this->request->getPost('project_id'),
            'employee_id' => $this->request->getPost('employee_id'),
            'position_id' => $this->request->getPost('position_id')
        ]);

        return redirect()->to('/admin/teams')
            ->with('success','Team berhasil diupdate');
    }

    public function delete($id)
    {
        $this->member->delete($id);

        return redirect()->to('/admin/teams')
            ->with('success','Team berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $team = $this->member->find($id);

        $status = ($team['status'] == 1) ? 0 : 1;

        $this->member->update($id,['status'=>$status]);

        return redirect()->back();
    }

    public function addMember($id)
    {
        $employee_id = $this->request->getPost('employee_id');

        $this->member->insert([
            'project_id' => $id,
            'employee_id' => $employee_id
        ]);

        return redirect()->back();
    }

    public function removeMember($team,$employee)
    {
        $this->db->table('project_members')
            ->where('project_id',$team)
            ->where('employee_id',$employee)
            ->delete();

        return redirect()->back();
    }

    public function teamProjects($id)
    {
        $builder = $this->db->table('projects');

        $builder->where('id',$id);

        $data = [
            'title'=>'Team Projects',
            'projects'=>$builder->get()->getResultArray()
        ];

        return view('/admin/teams/team_projects',$data);
    }

    public function teamMembers($id)
    {
        $builder = $this->db->table('project_members pm');

        $builder->select('employees.first_name,positions.name');

        $builder->join('employees','employees.id=pm.employee_id');
        $builder->join('positions','positions.id=pm.position_id');

        $builder->where('pm.project_id',$id);

        $data = [
            'title'=>'Team Members',
            'members'=>$builder->get()->getResultArray()
        ];

        return view('/admin/teams/team_members',$data);
    }
}