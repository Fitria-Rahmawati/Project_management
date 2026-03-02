<?php

namespace App\Controllers;
use App\Models\ProjectMemberModel;

class ProjectMembers extends BaseController
{
    protected $member;

    public function __construct()
    {
        $this->member = new ProjectMemberModel();
    }

    public function index($projectId)
    {
        return view('project_members/index', [
            'title'   => 'Anggota Proyek',
            'members' => $this->member
                ->where('project_id',$projectId)
                ->findAll()
        ]);
    }

    public function store()
    {
        $this->member->save($this->request->getPost());
        return redirect()->back();
    }

    public function delete($id)
    {
        $this->member->delete($id);
        return redirect()->back();
    }
}