<?php

namespace App\Controllers;
use App\Models\IssueModel;
use App\Models\IssueLogModel;

class Issues extends BaseController
{
    protected $issue;
    protected $log;

    public function __construct()
    {
        $this->issue = new IssueModel();
        $this->log   = new IssueLogModel();
    }

    public function index($projectId)
    {
        return view('issues/index', [
            'title'  => 'Daftar Issue',
            'issues' => $this->issue
                ->where('project_id',$projectId)
                ->findAll()
        ]);
    }

    public function create($projectId)
    {
        return view('issues/create', [
            'project_id'=>$projectId,
            'title' => 'Tambah Issue'
        ]);
        
    }

    public function store()
    {
        $this->issue->save([
            'project_id'   => $this->request->getPost('project_id'),
            'title'        => $this->request->getPost('title'),
            'description'  => $this->request->getPost('description'),
            'priority'     => $this->request->getPost('priority'),
            'status'       => 'open',
            'reported_by'  => session('user_id'),
            'assigned_to'  => $this->request->getPost('assigned_to')
        ]);
        return redirect()->to('/projects');
    }

    public function updateStatus($id)
    {
        $old = $this->issue->find($id)['status'];
        $new = $this->request->getPost('status');

        $this->issue->update($id, ['status'=>$new]);

        $this->log->insert([
            'issue_id'   => $id,
            'old_status' => $old,
            'new_status' => $new,
            'changed_by'=> session('user_id'),
            'changed_at'=> date('Y-m-d H:i:s')
        ]);

        return redirect()->back();
    }
}