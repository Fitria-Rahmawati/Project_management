<?php

namespace App\Controllers\Client;

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
        $companyId = session()->get('company_id');

        $issues = $this->db->table('issues i')
            ->select('i.*, p.project_name, assignee.username as assignee_name')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
            ->where('p.company_id', $companyId)
            ->orderBy('i.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $totalIssues = count($issues);
        $openIssues = $this->db->table('issues i')
            ->join('projects p', 'p.id = i.project_id')
            ->where('p.company_id', $companyId)
            ->where('i.status', 'open')
            ->countAllResults();
        $inProgressIssues = $this->db->table('issues i')
            ->join('projects p', 'p.id = i.project_id')
            ->where('p.company_id', $companyId)
            ->where('i.status', 'in_progress')
            ->countAllResults();
        $doneIssues = $this->db->table('issues i')
            ->join('projects p', 'p.id = i.project_id')
            ->where('p.company_id', $companyId)
            ->where('i.status', 'done')
            ->countAllResults();

        $data = [
            'title' => 'Riwayat Kendala',
            'issues' => $issues,
            'totalIssues' => $totalIssues,
            'openIssues' => $openIssues,
            'inProgressIssues' => $inProgressIssues,
            'doneIssues' => $doneIssues
        ];

        return view('client/issues/index', $data);
    }

    public function create()
    {
        $companyId = session()->get('company_id');

        $projects = $this->db->table('projects')
            ->where('company_id', $companyId)
            ->where('status !=', 'completed')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Lapor Kendala Baru',
            'projects' => $projects
        ];

        return view('client/issues/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'project_id' => 'required',
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[5]',
            'priority' => 'required|in_list[low,medium,high]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        $companyId = session()->get('company_id');

        $project = $this->db->table('projects')
            ->where('id', $this->request->getPost('project_id'))
            ->where('company_id', $companyId)
            ->get()
            ->getRow();

        if (!$project) {
            return redirect()->back()->with('error', 'Proyek tidak ditemukan');
        }

        $data = [
            'project_id' => $this->request->getPost('project_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 'open',
            'reporter_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('issues')->insert($data);

        $this->db->table('activity_logs')->insert([
            'user_id' => $userId,
            'activity' => 'Melaporkan kendala baru: ' . $this->request->getPost('title'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/client/issues')
            ->with('success', 'Kendala berhasil dilaporkan');
    }

    public function show($id)
    {
        $companyId = session()->get('company_id');

        $issue = $this->db->table('issues i')
            ->select('i.*, p.project_name, reporter.username as reporter_name, assignee.username as assignee_name')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users reporter', 'reporter.id = i.reporter_id', 'left')
            ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
            ->where('i.id', $id)
            ->where('p.company_id', $companyId)
            ->get()
            ->getRowArray();

        if (!$issue) {
            return redirect()->to('/client/issues')->with('error', 'Kendala tidak ditemukan');
        }

        $history = $this->db->table('issue_history')
            ->where('issue_id', $id)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Kendala',
            'issue' => $issue,
            'history' => $history
        ];

        return view('client/issues/show', $data);
    }
}