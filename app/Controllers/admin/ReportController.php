<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\IssueModel;
use App\Models\UserModel;
use App\Models\CompanyModel;

class ReportController extends BaseController
{
    protected $project;
    protected $issue;
    protected $user;
    protected $company;
    protected $db;

    public function __construct()
    {
        $this->project = new ProjectModel();
        $this->issue = new IssueModel();
        $this->user = new UserModel();
        $this->company = new CompanyModel();
        $this->db = \Config\Database::connect();
    }
   public function index()
{
    $totalProjects = $this->project->countAll();
    $totalIssues = $this->issue->countAll();
    $completedIssues = $this->issue->where('status', 'Done')->countAllResults();
    $overdueIssues = $this->db->table('issues')
        ->where('due_date <', date('Y-m-d'))
        ->where('status !=', 'Done')
        ->where('status !=', 'Closed')
        ->countAllResults();
    $overdueIssuesList = $this->db->table('issues i')
        ->select('i.*, p.project_name, assignee.username as assignee_name')
        ->join('projects p', 'p.id = i.project_id')
        ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
        ->where('i.due_date <', date('Y-m-d'))
        ->where('i.status !=', 'Done')
        ->where('i.status !=', 'Closed')
        ->limit(5)
        ->get()
        ->getResultArray();
    
    $topStaff = $this->db->table('users u')
        ->select('
            u.id,
            u.username,
            e.first_name,
            e.last_name,
            pos.position_name,
            (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Done") as completed
        ')
        ->join('employees e', 'e.user_id = u.id', 'left')
        ->join('positions pos', 'pos.id = e.position_id', 'left')
        ->where('u.role_id', 4)
        ->orderBy('completed', 'DESC')
        ->limit(5)
        ->get()
        ->getResultArray();
    
    $issuesByStatus = $this->db->table('issues')
        ->select('status, COUNT(*) as total')
        ->groupBy('status')
        ->get()
        ->getResultArray();
    
    $issuesByPriority = $this->db->table('issues')
        ->select('priority, COUNT(*) as total')
        ->groupBy('priority')
        ->get()
        ->getResultArray();
    
    $projectsByStatus = $this->db->table('projects')
        ->select('status, COUNT(*) as total')
        ->groupBy('status')
        ->get()
        ->getResultArray();
    
    $totalStaff = $this->db->table('users')
        ->where('role_id', 4)
        ->countAllResults();

    $data = [
        'title' => 'Dashboard Laporan',
        'totalProjects' => $totalProjects,
        'totalIssues' => $totalIssues,
        'completedIssues' => $completedIssues,
        'overdueIssues' => $overdueIssues,
        'totalStaff' => $totalStaff,
        'completionRate' => $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0,
        'issuesByStatus' => $issuesByStatus,
        'issuesByPriority' => $issuesByPriority,
        'projectsByStatus' => $projectsByStatus,
        'overdueIssuesList' => $overdueIssuesList, 
        'topStaff' => $topStaff
    ];

    return view('admin/reports/index', $data);
}

    public function projects()
    {
        $projects = $this->db->table('projects p')
            ->select('
                p.*,
                c.company_name,
                u.username as manager_name,
                (SELECT COUNT(*) FROM issues WHERE project_id = p.id) as total_issues,
                (SELECT COUNT(*) FROM issues WHERE project_id = p.id AND status = "Done") as completed_issues,
                (SELECT COUNT(*) FROM issues WHERE project_id = p.id AND status = "Closed") as closed_issues,
                (SELECT COUNT(*) FROM issues WHERE project_id = p.id AND due_date < CURDATE() AND status NOT IN ("Done", "Closed")) as overdue_issues
            ')
            ->join('companies c', 'c.id = p.company_id', 'left')
            ->join('users u', 'u.id = p.project_manager_id', 'left')
            ->get()
            ->getResultArray();
        foreach ($projects as &$project) {
            $total = $project['total_issues'];
            $completed = $project['completed_issues'] + $project['closed_issues'];
            $project['progress'] = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
        }

        $data = [
            'title' => 'Laporan Progress Proyek',
            'projects' => $projects
        ];

        return view('admin/reports/projects', $data);
    }

    public function issues()
    {
        $projectId = $this->request->getGet('project_id');
        $dateFrom = $this->request->getGet('date_from');
        $dateTo = $this->request->getGet('date_to');

        $builder = $this->db->table('issues i');
        $builder->select('
            i.*,
            p.project_name,
            reporter.username as reporter_name,
            assignee.username as assignee_name
        ');
        $builder->join('projects p', 'p.id = i.project_id');
        $builder->join('users reporter', 'reporter.id = i.reporter_id', 'left');
        $builder->join('users assignee', 'assignee.id = i.assignee_id', 'left');

        if ($projectId) {
            $builder->where('i.project_id', $projectId);
        }
        if ($dateFrom) {
            $builder->where('i.created_at >=', $dateFrom . ' 00:00:00');
        }
        if ($dateTo) {
            $builder->where('i.created_at <=', $dateTo . ' 23:59:59');
        }

        $builder->orderBy('i.created_at', 'DESC');

        $issues = $builder->get()->getResultArray();
        $stats = [
            'total' => count($issues),
            'by_status' => [],
            'by_priority' => [],
            'by_type' => []
        ];

        foreach ($issues as $issue) {
            $stats['by_status'][$issue['status']] = ($stats['by_status'][$issue['status']] ?? 0) + 1;
            $stats['by_priority'][$issue['priority']] = ($stats['by_priority'][$issue['priority']] ?? 0) + 1;
            $stats['by_type'][$issue['issue_type']] = ($stats['by_type'][$issue['issue_type']] ?? 0) + 1;
        }

        $data = [
            'title' => 'Laporan Issue Summary',
            'issues' => $issues,
            'stats' => $stats,
            'projects' => $this->project->findAll(),
            'filters' => [
                'project_id' => $projectId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ]
        ];

        return view('admin/reports/issues', $data);
    }

    public function team()
    {
        $staff = $this->db->table('users u')
            ->select('
                u.id,
                u.username,
                u.email,
                r.name as role_name,
                e.first_name,
                e.last_name,
                e.position_id,
                pos.position_name,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id) as assigned_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Done") as completed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Closed") as closed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND due_date < CURDATE() AND status NOT IN ("Done", "Closed")) as overdue_issues,
                (SELECT SUM(actual_hours) FROM issues WHERE assignee_id = u.id) as total_hours
            ')
            ->join('roles r', 'r.id = u.role_id')
            ->join('employees e', 'e.user_id = u.id', 'left')
            ->join('positions pos', 'pos.id = e.position_id', 'left')
            ->where('u.role_id', 4) 
            ->orWhere('u.role_id', 2) 
            ->get()
            ->getResultArray();
        foreach ($staff as &$member) {
            $assigned = $member['assigned_issues'];
            $completed = $member['completed_issues'] + $member['closed_issues'];
            $member['completion_rate'] = $assigned > 0 ? round(($completed / $assigned) * 100, 2) : 0;
        }

        $data = [
            'title' => 'Laporan Kinerja Tim',
            'staff' => $staff
        ];

        return view('admin/reports/team', $data);
    }

    public function clients()
    {
        $clients = $this->db->table('companies c')
            ->select('
                c.*,
                (SELECT COUNT(*) FROM projects WHERE company_id = c.id) as total_projects,
                (SELECT COUNT(*) FROM issues i 
                 JOIN projects p ON p.id = i.project_id 
                 WHERE p.company_id = c.id) as total_issues,
                (SELECT COUNT(*) FROM issues i 
                 JOIN projects p ON p.id = i.project_id 
                 WHERE p.company_id = c.id AND i.status = "Done") as completed_issues,
                (SELECT COUNT(*) FROM issues i 
                 JOIN projects p ON p.id = i.project_id 
                 WHERE p.company_id = c.id AND i.status = "Closed") as closed_issues
            ')
            ->where('c.company_type', 'client')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Laporan Client',
            'clients' => $clients
        ];

        return view('/admin/reports/clients', $data);
    }

    public function export($type)
    {
        $filename = $type . '_report_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        switch ($type) {
            case 'projects':
                fputcsv($output, ['ID', 'Project', 'Type', 'Company', 'Manager', 'Total Issues', 'Completed', 'Progress %', 'Status']);
                $projects = $this->db->table('projects p')
                    ->select('p.id, p.project_name, p.project_type, c.company_name, u.username, p.status')
                    ->join('companies c', 'c.id = p.company_id', 'left')
                    ->join('users u', 'u.id = p.project_manager_id', 'left')
                    ->get()
                    ->getResultArray();
                foreach ($projects as $p) {
                    fputcsv($output, $p);
                }
                break;

            case 'issues':
                fputcsv($output, ['ID', 'Title', 'Type', 'Project', 'Status', 'Priority', 'Reporter', 'Assignee', 'Created', 'Due Date']);
                $issues = $this->db->table('issues i')
                    ->select('i.id, i.title, i.issue_type, p.project_name, i.status, i.priority, reporter.username as reporter, assignee.username as assignee, i.created_at, i.due_date')
                    ->join('projects p', 'p.id = i.project_id')
                    ->join('users reporter', 'reporter.id = i.reporter_id', 'left')
                    ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
                    ->get()
                    ->getResultArray();
                foreach ($issues as $i) {
                    fputcsv($output, $i);
                }
                break;
        }

        fclose($output);
        exit;
    }
}