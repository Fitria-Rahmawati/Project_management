<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;

class IssueController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $issues = $this->db->table('issues i')
            ->select('i.*, p.project_name')
            ->join('projects p', 'p.id = i.project_id')
            ->where('i.reporter_id', $userId)
            ->orderBy('i.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'My Issues',
            'issues' => $issues
        ];

        return view('staff/issues/index', $data);
    }

    public function create()
    {
        $userId = session()->get('user_id');

       
        $projects = $this->db->table('project_members pm')
            ->select('p.id, p.project_name')
            ->join('projects p', 'p.id = pm.project_id')
            ->where('pm.user_id', $userId)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Report New Issue',
            'projects' => $projects
        ];

        return view('staff/issues/create', $data);
    }

   public function store()
{
    $userId = session()->get('user_id');
    $issueType = $this->request->getPost('issue_type');

    $data = [
        'project_id' => $this->request->getPost('project_id'),
        'issue_type' => $issueType,
        'title' => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'priority' => $this->request->getPost('priority'),
        'status' => 'To Do',
        'reporter_id' => $userId,
        'assignee_id' => $userId,  // ✅ ASSIGN KE DIRI SENDIRI
        'due_date' => $this->request->getPost('due_date') ?: null,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $this->db->table('issues')->insert($data);
    $issueId = $this->db->insertID();

    // Catat ke log
    $this->db->table('issue_logs')->insert([
        'issue_id' => $issueId,
        'old_status' => '',
        'new_status' => 'To Do',
        'changed_by' => $userId,
        'changed_at' => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/staff/tasks')->with('success', 'Task berhasil dibuat dan muncul di My Tasks');
}

    public function show($id)
    {
        $userId = session()->get('user_id');

        $issue = $this->db->table('issues i')
            ->select('i.*, p.project_name, assignee.username as assignee_name')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
            ->where('i.id', $id)
            ->where('i.reporter_id', $userId)
            ->get()
            ->getRowArray();

        if (!$issue) {
            return redirect()->to('staff/issues')->with('error', 'Issue tidak ditemukan');
        }

        $data = [
            'title' => 'Issue Detail',
            'issue' => $issue
        ];

        return view('staff/issues/show', $data);
    }
}