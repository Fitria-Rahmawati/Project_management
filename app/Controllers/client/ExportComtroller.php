<?php

namespace App\Controllers\client;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportController extends BaseController
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    /**
     * Export Detail Proyek ke PDF
     * URL: /client/export/project/1
     */
    public function project($id)
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
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Download PDF
        $filename = 'Proyek_' . str_replace(' ', '_', $project['project_name']) . '_' . date('Y-m-d') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }

    /**
     * Export Progress Report ke PDF
     * URL: /client/export/progress/1
     */
    public function progress($id = null)
    {
        $companyId = session()->get('company_id');

        // Ambil semua proyek
        $projects = $this->db->table('projects')
            ->where('company_id', $companyId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Hitung progress setiap proyek
        foreach ($projects as &$p) {
            $total = $this->db->table('issues')
                ->where('project_id', $p['id'])
                ->countAllResults();
            $completed = $this->db->table('issues')
                ->where('project_id', $p['id'])
                ->where('status', 'Done')
                ->countAllResults();
            $p['progress'] = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
            $p['total_issues'] = $total;
            $p['completed_issues'] = $completed;
        }

        // Data untuk view
        $data = [
            'projects' => $projects,
            'companyName' => session()->get('company_name') ?? 'Perusahaan Client'
        ];

        // Load view menjadi HTML
        $html = view('client/export/progress_pdf', $data);

        // Konfigurasi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Generate PDF (landscape karena tabel lebar)
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // Download PDF
        $filename = 'Progress_Report_' . date('Y-m-d') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }

    /**
     * Export Detail Issue ke PDF
     * URL: /client/export/issue/1
     */
    public function issue($id = null)
    {
        // Cek apakah ID ada
        if ($id === null) {
            return redirect()->back()->with('error', 'ID Issue tidak ditemukan');
        }

        $companyId = session()->get('company_id');

        // Ambil data issue
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

        // Data untuk view
        $data = [
            'issue' => $issue,
            'companyName' => session()->get('company_name') ?? 'Perusahaan Client'
        ];

        // Load view menjadi HTML
        $html = view('client/export/issue_pdf', $data);

        // Konfigurasi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Download PDF
        $filename = 'Issue_' . str_replace(' ', '_', $issue['title']) . '_' . date('Y-m-d') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }
}