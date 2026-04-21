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

    // Ambil history dari tabel issue_logs
    $logs = $this->db->table('issue_logs')
        ->select('issue_logs.*, u.username as changed_by_name')
        ->join('users u', 'u.id = issue_logs.changed_by', 'left')
        ->where('issue_id', $id)
        ->orderBy('changed_at', 'ASC')
        ->get()
        ->getResultArray();

    // Format ulang history untuk view
    $history = [];
    foreach ($logs as $log) {
        $history[] = [
            'description' => 'Status berubah dari "' . ($log['old_status'] ?? '-') . '" menjadi "' . ($log['new_status'] ?? '-') . '"',
            'created_at' => $log['changed_at'],
            'changed_by' => $log['changed_by_name'] ?? 'System'
        ];
    }

    $data = [
        'title' => 'Detail Kendala',
        'issue' => $issue,
        'history' => $history
    ];

    return view('client/issues/show', $data);
}
    public function exportPdf($id = null)
{
    if ($id === null) {
        return redirect()->back()->with('error', 'ID Issue tidak ditemukan');
    }

    $companyId = session()->get('company_id');

    $issue = $this->db->table('issues i')
        ->select('i.*, p.project_name, assignee.username as assignee_name')
        ->join('projects p', 'p.id = i.project_id')
        ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
        ->where('i.id', $id)
        ->where('p.company_id', $companyId)
        ->get()
        ->getRowArray();

    if (!$issue) {
        return redirect()->back()->with('error', 'Issue tidak ditemukan');
    }

    $data = [
        'issue' => $issue,
        'companyName' => session()->get('company_name') ?? 'Perusahaan Client'
    ];

    $html = view('client/export/issue_pdf', $data);

    $options = new \Dompdf\Options();
    $options->set('defaultFont', 'Helvetica');
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $filename = 'Issue_' . str_replace(' ', '_', $issue['title']) . '_' . date('Y-m-d') . '.pdf';
    $dompdf->stream($filename, ['Attachment' => true]);
    exit;
}
}