<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

class ProjectController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $companyId = session()->get('company_id');

        $projects = $this->db->table('projects')
            ->where('company_id', $companyId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($projects as &$project) {
            $totalIssues = $this->db->table('issues')
                ->where('project_id', $project['id'])
                ->countAllResults();
            $completedIssues = $this->db->table('issues')
                ->where('project_id', $project['id'])
                ->where('status', 'Done')
                ->countAllResults();
            $project['progress'] = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;
        }

        $data = [
            'title' => 'My Projects',
            'projects' => $projects
        ];

        return view('client/project/index', $data);
    }

    public function show($id)
    {
        $companyId = session()->get('company_id');

        // Ambil detail 1 proyek
        $project = $this->db->table('projects')
            ->where('id', $id)
            ->where('company_id', $companyId)
            ->get()
            ->getRowArray();

        if (!$project) {
            return redirect()->to('/client/projects')->with('error', 'Proyek tidak ditemukan');
        }

        //  PERBAIKAN: Ambil SEMUA proyek untuk perhitungan ongoing di view
        $allProjects = $this->db->table('projects')
            ->where('company_id', $companyId)
            ->get()
            ->getResultArray();

        $issues = $this->db->table('issues')
            ->select('issues.*, assignee.username as assignee_name')
            ->join('users assignee', 'assignee.id = issues.assignee_id', 'left')
            ->where('project_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Project Detail',
            'project' => $project,
            'projects' => $allProjects,  
            'issues' => $issues
        ];

        return view('client/project/show', $data);
    }

    // ========== METHOD UNTUK KOMENTAR (SUDAH BENAR) ==========
    public function addComment($id)
    {
        $comment = $this->request->getPost('comment');
        $userId = session()->get('user_id');
        
        if (empty($comment)) {
            return redirect()->back()->with('error', 'Komentar tidak boleh kosong');
        }
        
        $companyId = session()->get('company_id');
        $project = $this->db->table('projects')
            ->where('id', $id)
            ->where('company_id', $companyId)
            ->get()
            ->getRow();
        
        if (!$project) {
            return redirect()->back()->with('error', 'Proyek tidak ditemukan');
        }
        
        $this->db->table('projects')
            ->where('id', $id)
            ->update([
                'client_comments' => $comment,
                'comments_updated_at' => date('Y-m-d H:i:s')
            ]);
        
        $this->db->table('activity_logs')->insert([
            'user_id' => $userId,
            'activity' => 'Memberikan komentar pada proyek: ' . $project->project_name,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->back()->with('success', 'Komentar berhasil dikirim');
    }
    public function exportPdf($id = null)
{
    // Cek apakah ID ada
    if ($id === null) {
        return redirect()->back()->with('error', 'ID Proyek tidak ditemukan');
    }

    $companyId = session()->get('company_id');

    // Ambil data proyek
    $project = $this->db->table('projects')
        ->where('id', $id)
        ->where('company_id', $companyId)
        ->get()
        ->getRowArray();

    if (!$project) {
        return redirect()->back()->with('error', 'Proyek tidak ditemukan');
    }

    // Hitung progress
    $totalIssues = $this->db->table('issues')
        ->where('project_id', $id)
        ->countAllResults();
    
    $completedIssues = $this->db->table('issues')
        ->where('project_id', $id)
        ->where('status', 'Done')
        ->countAllResults();
    
    $project['progress'] = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;

    // Ambil issues
    $issues = $this->db->table('issues')
        ->select('issues.*, assignee.username as assignee_name')
        ->join('users assignee', 'assignee.id = issues.assignee_id', 'left')
        ->where('project_id', $id)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getResultArray();

    // Data untuk view
    $data = [
        'project' => $project,
        'issues' => $issues,
        'companyName' => session()->get('company_name') ?? 'Perusahaan Client'
    ];

    // Load view menjadi HTML
    $html = view('client/export/project_pdf', $data);

    // Konfigurasi DomPDF
    $options = new \Dompdf\Options();
    $options->set('defaultFont', 'Helvetica');
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    // Generate PDF
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Download PDF
    $filename = 'Proyek_' . str_replace(' ', '_', $project['project_name']) . '_' . date('Y-m-d') . '.pdf';
    $dompdf->stream($filename, ['Attachment' => true]);
    exit;
}
}