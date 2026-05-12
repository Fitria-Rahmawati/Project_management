<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;

class TaskController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $status = $this->request->getGet('status');
        $priority = $this->request->getGet('priority');
        $search = $this->request->getGet('search');

        $builder = $this->db->table('issues i');
        $builder->select('i.*, p.project_name')
            ->join('projects p', 'p.id = i.project_id')
            ->where('i.assignee_id', $userId)
            ->whereIn('i.issue_type', ['task', 'bug', 'story'])
            ->orderBy('i.due_date', 'ASC');

        if ($status) {
            $builder->where('i.status', $status);
        }
        if ($priority) {
            $builder->where('i.priority', $priority);
        }
        if ($search) {
            $builder->groupStart()
                ->like('i.title', $search)
                ->orLike('i.description', $search)
                ->groupEnd();
        }

        // ✅ AMBIL DATA TASKS
        $tasks = $builder->get()->getResultArray();

        $data = [
            'title' => 'My Tasks',
            'tasks' => $tasks,        // ← TAMBAHKAN INI
            'status' => $status,
            'priority' => $priority,
            'search' => $search
        ];

        return view('staff/tasks/index', $data);
    }

    public function show($id)
    {
        $userId = session()->get('user_id');

        $task = $this->db->table('issues i')
            ->select('i.*, p.project_name, reporter.username as reporter_name')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users reporter', 'reporter.id = i.reporter_id', 'left')
            ->where('i.id', $id)
            ->where('i.assignee_id', $userId)
            ->get()
            ->getRowArray();

        if (!$task) {
            return redirect()->to('staff/tasks')->with('error', 'Task tidak ditemukan');
        }

        // Ambil komentar (bukan history)
        $comments = $this->db->table('issue_logs')
            ->select('issue_logs.*, users.username as user_name')
            ->join('users', 'users.id = issue_logs.changed_by', 'left')
            ->where('issue_id', $id)
            ->where('new_status', 'IS', null)  // Hanya komentar
            ->orderBy('changed_at', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Task Detail',
            'task' => $task,
            'comments' => $comments,
            'totalHours' => $task['actual_hours'] ?? 0
        ];
        return view('staff/tasks/show', $data);
    }

    public function updateStatus($id)
    {
        $userId = session()->get('user_id');
        $status = $this->request->getPost('status');

        $task = $this->db->table('issues')
            ->where('id', $id)
            ->where('assignee_id', $userId)
            ->get()
            ->getRowArray();

        if (!$task) {
            return redirect()->back()->with('error', 'Task tidak ditemukan');
        }

        $oldStatus = $task['status'];

        $this->db->table('issues')
            ->where('id', $id)
            ->update([
                'status' => $status, 
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        $this->db->table('issue_logs')->insert([
            'issue_id' => $id,
            'old_status' => $oldStatus,
            'new_status' => $status,
            'changed_by' => $userId,
            'changed_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Status berhasil diupdate menjadi ' . $status);
    }

    public function addComment($id)
    {
        $userId = session()->get('user_id');
        $comment = $this->request->getPost('comment');

        if (!$comment) {
            return redirect()->back()->with('error', 'Komentar tidak boleh kosong');
        }

        // Simpan komentar (new_status = null)
        $this->db->table('issue_logs')->insert([
            'issue_id' => $id,
            'old_status' => $comment,    // Simpan komentar di old_status
            'new_status' => null,
            'changed_by' => $userId,
            'changed_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function logTime($id)
    {
        $userId = session()->get('user_id');
        $hours = $this->request->getPost('hours');
        $description = $this->request->getPost('description');

        if (!$hours || $hours <= 0) {
            return redirect()->back()->with('error', 'Jam harus diisi dengan benar');
        }

        $task = $this->db->table('issues')
            ->where('id', $id)
            ->where('assignee_id', $userId)
            ->get()
            ->getRowArray();

        if (!$task) {
            return redirect()->back()->with('error', 'Task tidak ditemukan');
        }

        $currentHours = $task['actual_hours'] ?? 0;
        $newHours = $currentHours + $hours;

        $this->db->table('issues')
            ->where('id', $id)
            ->update(['actual_hours' => $newHours]);

        $this->db->table('issue_logs')->insert([
            'issue_id' => $id,
            'old_status' => $description ?? 'Logged ' . $hours . ' hours',
            'new_status' => (string)$newHours,
            'changed_by' => $userId,
            'changed_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', $hours . ' jam berhasil dicatat');
    }

    public function export()
    {
        $userId = session()->get('user_id');
        $status = $this->request->getGet('status');
        $priority = $this->request->getGet('priority');
        $search = $this->request->getGet('search');

        $builder = $this->db->table('issues i');
        $builder->select('i.*, p.project_name')
            ->join('projects p', 'p.id = i.project_id')
            ->where('i.assignee_id', $userId)
            ->whereIn('i.issue_type', ['task', 'bug', 'story']);

        if ($status) $builder->where('i.status', $status);
        if ($priority) $builder->where('i.priority', $priority);
        if ($search) {
            $builder->groupStart()
                ->like('i.title', $search)
                ->orLike('i.description', $search)
                ->groupEnd();
        }

        $tasks = $builder->get()->getResultArray();

        $filename = 'my_tasks_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Title', 'Project', 'Status', 'Priority', 'Due Date', 'Created At']);

        foreach ($tasks as $task) {
            fputcsv($output, [
                $task['id'],
                $task['title'],
                $task['project_name'],
                $task['status'],
                $task['priority'],
                $task['due_date'] ?? '-',
                date('d/m/Y', strtotime($task['created_at']))
            ]);
        }

        fclose($output);
        exit;
    }
}