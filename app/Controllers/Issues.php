<?php

namespace App\Controllers;

use App\Models\IssueModel;
use App\Models\ProjectModel;
use App\Models\UserModel;
use App\Models\EmployeeModel;

class Issues extends BaseController
{
    protected $issue;
    protected $project;
    protected $user;
    protected $employee;
    protected $db;

    public function __construct()
    {
        $this->issue = new IssueModel();
        $this->project = new ProjectModel();
        $this->user = new UserModel();
        $this->employee = new EmployeeModel();
        $this->db = \Config\Database::connect();
        helper('text');
    }

    public function index()
    {
        $projectId = $this->request->getGet('project');
        $type = $this->request->getGet('type');
        $status = $this->request->getGet('status');
        $priority = $this->request->getGet('priority');
        $assignee = $this->request->getGet('assignee');
        $builder = $this->db->table('issues i');
        $builder->select('
            i.*, 
            p.project_name,
            p.project_type,
            reporter.username as reporter_name,
            assignee.username as assignee_name
        ');
        $builder->join('projects p', 'p.id = i.project_id');
        $builder->join('users reporter', 'reporter.id = i.reporter_id', 'left');
        $builder->join('users assignee', 'assignee.id = i.assignee_id', 'left');
        if ($projectId) {
            $builder->where('i.project_id', $projectId);
        }
        if ($type) {
            $builder->where('i.issue_type', $type);
        }
        if ($status) {
            $builder->where('i.status', $status);
        }
        if ($priority) {
            $builder->where('i.priority', $priority);
        }
        if ($assignee) {
            if ($assignee == 'unassigned') {
                $builder->where('i.assignee_id IS NULL');
            } else {
                $builder->where('i.assignee_id', $assignee);
            }
        }

        $builder->orderBy('i.created_at', 'DESC');

        $data = [
            'title' => 'Manajemen Issues',
            'issues' => $builder->get()->getResultArray(),
            'projects' => $this->project->findAll(),
            'users' => $this->user->findAll(),
            'filters' => [
                'project' => $projectId,
                'type' => $type,
                'status' => $status,
                'priority' => $priority,
                'assignee' => $assignee
            ]
        ];

        return view('admin/issues/index', $data);
    }

    public function show($id)
    {
        $issue = $this->issue->getIssueWithDetails($id);

        if (!$issue) {
            return redirect()->to('/admin/issues')
                ->with('error', 'Issue tidak ditemukan');
        }
        $data = [
            'title' => 'Detail Issue #' . $id,
            'issue' => $issue,
            'users' => $this->user->where('is_active', 1)->findAll(),
            'projects' => $this->project->findAll(),
            'parent_issues' => $this->issue->where('id !=', $id)
                                          ->where('status !=', 'Closed')
                                          ->where('project_id', $issue['project_id'])
                                          ->findAll()
        ];

        return view('admin/issues/show', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Buat Issue Baru',
            'projects' => $this->project->findAll(),
            'users' => $this->user->where('is_active', 1)->findAll(),
            'parent_issues' => $this->issue->where('status !=', 'Closed')->findAll()
        ];

        return view('admin/issues/create', $data);
    }

    public function store()
    {
        $rules = [
            'project_id' => 'required|numeric',
            'issue_type' => 'required|in_list[task,bug,story,epic,subtask]',
            'title' => 'required|min_length[3]|max_length[255]',
            'priority' => 'required|in_list[Lowest,Low,Medium,High,Highest]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Validasi gagal, periksa kembali input Anda');
        }
        $data = [
            'project_id' => $this->request->getPost('project_id'),
            'issue_type' => $this->request->getPost('issue_type'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 'To Do',
            'reporter_id' => session()->get('user_id'), 
            'assignee_id' => $this->request->getPost('assignee_id') ?: null,
            'parent_issue_id' => $this->request->getPost('parent_issue_id') ?: null,
            'due_date' => $this->request->getPost('due_date') ?: null,
            'estimated_hours' => $this->request->getPost('estimated_hours') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->issue->insert($data);
        $issueId = $this->issue->insertID();
        $this->db->table('issue_logs')->insert([
            'issue_id' => $issueId,
            'change_by' => session()->get('user_id'),
            'field_name' => 'status',
            'old_value' => '',
            'new_value' => 'To Do',
            'comment' => 'Issue created',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if ($data['assignee_id']) {
            $assigneeName = $this->user->find($data['assignee_id'])['username'];
            $this->db->table('issue_logs')->insert([
                'issue_id' => $issueId,
                'change_by' => session()->get('user_id'),
                'field_name' => 'assignee',
                'old_value' => 'Unassigned',
                'new_value' => $assigneeName,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/admin/issues/' . $issueId)
            ->with('success', 'Issue berhasil dibuat');
    }

    public function edit($id)
    {
        $issue = $this->issue->find($id);

        if (!$issue) {
            return redirect()->to('/admin/issues')
                ->with('error', 'Issue tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Issue #' . $id,
            'issue' => $issue,
            'projects' => $this->project->findAll(),
            'users' => $this->user->where('is_active', 1)->findAll(),
            'parent_issues' => $this->issue->where('id !=', $id)
                                          ->where('status !=', 'Closed')
                                          ->where('project_id', $issue['project_id'])
                                          ->findAll()
        ];

        return view('admin/issues/edit', $data);
    }

    public function update($id)
    {
        $issue = $this->issue->find($id);

        if (!$issue) {
            return redirect()->to('/admin/issues')
                ->with('error', 'Issue tidak ditemukan');
        }
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'priority' => 'required|in_list[Lowest,Low,Medium,High,Highest]',
            'status' => 'required|in_list[To Do,In Progress,In Review,Done,Closed]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Validasi gagal');
        }
        $oldData = $issue;
        $newData = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => $this->request->getPost('status'),
            'assignee_id' => $this->request->getPost('assignee_id') ?: null,
            'due_date' => $this->request->getPost('due_date') ?: null,
            'estimated_hours' => $this->request->getPost('estimated_hours') ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->issue->update($id, $newData);
        $this->logChanges($id, $oldData, $newData);

        return redirect()->to('/admin/issues/' . $id)
            ->with('success', 'Issue berhasil diupdate');
    }

    public function delete($id)
    {
        $issue = $this->issue->find($id);

        if (!$issue) {
            return redirect()->to('/admin/issues')
                ->with('error', 'Issue tidak ditemukan');
        }
        $hasChild = $this->issue->where('parent_issue_id', $id)->countAllResults();

        if ($hasChild > 0) {
            return redirect()->to('/admin/issues')
                ->with('error', 'Tidak bisa menghapus issue yang memiliki subtask');
        }
        $this->db->table('issue_logs')->where('issue_id', $id)->delete();
        $this->issue->delete($id);

        return redirect()->to('/admin/issues')
            ->with('success', 'Issue berhasil dihapus');
    }

    public function updateStatus($id)
    {
        $status = $this->request->getGet('status');

        if (!$status) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $validStatus = ['To Do', 'In Progress', 'In Review', 'Done', 'Closed'];
        if (!in_array($status, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $issue = $this->issue->find($id);

        if (!$issue) {
            return redirect()->back()->with('error', 'Issue tidak ditemukan');
        }

        $oldStatus = $issue['status'];

        $this->issue->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->db->table('issue_logs')->insert([
            'issue_id' => $id,
            'change_by' => session()->get('user_id'),
            'field_name' => 'status',
            'old_value' => $oldStatus,
            'new_value' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Status berhasil diupdate menjadi ' . $status);
    }

    public function assign($id)
    {
        $assigneeId = $this->request->getPost('assignee_id');

        $issue = $this->issue->find($id);

        if (!$issue) {
            return redirect()->back()->with('error', 'Issue tidak ditemukan');
        }

        $oldAssignee = $issue['assignee_id'];
        $oldName = $oldAssignee ? $this->user->find($oldAssignee)['username'] : 'Unassigned';
        $newName = $assigneeId ? $this->user->find($assigneeId)['username'] : 'Unassigned';

        $this->issue->update($id, [
            'assignee_id' => $assigneeId ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->db->table('issue_logs')->insert([
            'issue_id' => $id,
            'change_by' => session()->get('user_id'),
            'field_name' => 'assignee',
            'old_value' => $oldName,
            'new_value' => $newName,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Assignee berhasil diupdate menjadi ' . $newName);
    }

    public function addComment($id)
    {
        $comment = $this->request->getPost('comment');

        if (!$comment) {
            return redirect()->back()->with('error', 'Komentar tidak boleh kosong');
        }

        $issue = $this->issue->find($id);

        if (!$issue) {
            return redirect()->back()->with('error', 'Issue tidak ditemukan');
        }
        $this->db->table('issue_logs')->insert([
            'issue_id' => $id,
            'change_by' => session()->get('user_id'),
            'field_name' => null,
            'old_value' => null,
            'new_value' => null,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function logTime($id)
    {
        $hours = $this->request->getPost('hours');
        $description = $this->request->getPost('description');

        if (!$hours || $hours <= 0) {
            return redirect()->back()->with('error', 'Jam harus diisi dengan angka positif');
        }

        $issue = $this->issue->find($id);

        if (!$issue) {
            return redirect()->back()->with('error', 'Issue tidak ditemukan');
        }
        $currentHours = $issue['actual_hours'] ?? 0;
        $newHours = $currentHours + $hours;

        $this->issue->update($id, [
            'actual_hours' => $newHours,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->db->table('issue_logs')->insert([
            'issue_id' => $id,
            'change_by' => session()->get('user_id'),
            'field_name' => 'time_log',
            'old_value' => (string)$currentHours,
            'new_value' => (string)$newHours,
            'comment' => $description ?? 'Logged ' . $hours . ' hours',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', $hours . ' jam berhasil dicatat');
    }

    public function export()
    {
        $issues = $this->issue->getIssuesWithDetails();

        $filename = 'issues_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Type', 'Title', 'Project', 'Status', 'Priority', 'Reporter', 'Assignee', 'Created', 'Due Date']);

        foreach ($issues as $issue) {
            fputcsv($output, [
                $issue['id'],
                ucfirst($issue['issue_type']),
                $issue['title'],
                $issue['project_name'],
                $issue['status'],
                $issue['priority'],
                $issue['reporter_name'],
                $issue['assignee_name'] ?? 'Unassigned',
                date('d/m/Y', strtotime($issue['created_at'])),
                $issue['due_date'] ? date('d/m/Y', strtotime($issue['due_date'])) : '-'
            ]);
        }

        fclose($output);
        exit;
    }

    public function dashboard()
    {
        $byStatus = $this->issue->countByStatus();
        $byPriority = $this->issue->countByPriority();
        $overdue = $this->db->table('issues i')
            ->select('i.*, p.project_name, assignee.username as assignee_name')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
            ->where('i.due_date <', date('Y-m-d'))
            ->where('i.status !=', 'Done')
            ->where('i.status !=', 'Closed')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Dashboard Issues',
            'byStatus' => $byStatus,
            'byPriority' => $byPriority,
            'overdue' => $overdue
        ];

        return view('admin/issues/dashboard', $data);
    }

    private function logChanges($id, $old, $new)
    {
        $fieldsToCheck = ['title', 'description', 'priority', 'status', 'assignee_id', 'due_date', 'estimated_hours'];

        foreach ($fieldsToCheck as $field) {
            if (isset($old[$field]) && isset($new[$field]) && $old[$field] != $new[$field]) {
                $oldValue = $field == 'assignee_id' 
                    ? ($old[$field] ? $this->user->find($old[$field])['username'] : 'Unassigned')
                    : $old[$field];
                $newValue = $field == 'assignee_id'
                    ? ($new[$field] ? $this->user->find($new[$field])['username'] : 'Unassigned')
                    : $new[$field];

                $this->db->table('issue_logs')->insert([
                    'issue_id' => $id,
                    'changed_by' => session()->get('user_id'),
                    'field_name' => $field,
                    'old_value' => (string)$oldValue,
                    'new_value' => (string)$newValue,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}