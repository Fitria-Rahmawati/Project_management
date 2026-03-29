<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;

class MonitoringController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Monitoring Sistem',
            'totalProjects' => $this->db->table('projects')->countAllResults(),
            'totalIssues' => $this->db->table('issues')->countAllResults(),
            'totalUsers' => $this->db->table('users')->countAllResults(),
            'totalCompanies' => $this->db->table('companies')->countAllResults(),
          
            'projectsByStatus' => $this->db->table('projects')
                ->select('status, COUNT(*) as total')
                ->groupBy('status')
                ->get()
                ->getResultArray(),
            
            'issuesByStatus' => $this->db->table('issues')
                ->select('status, COUNT(*) as total')
                ->groupBy('status')
                ->get()
                ->getResultArray(),
            
            'issuesByPriority' => $this->db->table('issues')
                ->select('priority, COUNT(*) as total')
                ->groupBy('priority')
                ->get()
                ->getResultArray(),
          
            'recentActivities' => $this->getRecentActivities(),
         
            'topStaff' => $this->getTopStaff(),
            
            'overdueIssues' => $this->getOverdueIssues(),
            
            'projectProgress' => $this->getProjectProgress(),
            
            'userActivityStats' => $this->getUserActivityStats(),
        ];

        return view('superadmin/monitoring/index', $data);
    }

    private function getRecentActivities()
    {
        $activities = [];
        $recentUsers = $this->db->table('users')
            ->select('username, created_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user',
                'action' => 'User baru terdaftar',
                'name' => $user['username'],
                'time' => $user['created_at']
            ];
        }
        $recentProjects = $this->db->table('projects')
            ->select('project_name, created_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        foreach ($recentProjects as $project) {
            $activities[] = [
                'type' => 'project',
                'action' => 'Proyek baru dibuat',
                'name' => $project['project_name'],
                'time' => $project['created_at']
            ];
        }
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 10);
    }

    private function getTopStaff()
    {
        return $this->db->table('users u')
            ->select('
                u.id,
                u.username,
                e.first_name,
                e.last_name,
                pos.position_name,
                COUNT(i.id) as total_issues,
                SUM(CASE WHEN i.status = "Done" THEN 1 ELSE 0 END) as completed_issues
            ')
            ->join('employees e', 'e.user_id = u.id', 'left')
            ->join('positions pos', 'pos.id = e.position_id', 'left')
            ->join('issues i', 'i.assignee_id = u.id', 'left')
            ->where('u.role_id', 4)
            ->groupBy('u.id')
            ->orderBy('completed_issues', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
    }

    private function getOverdueIssues()
    {
        return $this->db->table('issues i')
            ->select('
                i.id,
                i.title,
                i.due_date,
                p.project_name,
                assignee.username as assignee_name
            ')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
            ->where('i.due_date <', date('Y-m-d'))
            ->where('i.status !=', 'Done')
            ->where('i.status !=', 'Closed')
            ->orderBy('i.due_date', 'ASC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    private function getProjectProgress()
    {
        return $this->db->table('projects p')
            ->select('
                p.id,
                p.project_name,
                c.company_name,
                COUNT(i.id) as total_issues,
                SUM(CASE WHEN i.status IN ("Done", "Closed") THEN 1 ELSE 0 END) as completed_issues,
                p.status
            ')
            ->join('companies c', 'c.id = p.company_id', 'left')
            ->join('issues i', 'i.project_id = p.id', 'left')
            ->groupBy('p.id')
            ->orderBy('p.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    private function getUserActivityStats()
    {
        $totalUsers = $this->db->table('users')->countAllResults();
        $activeUsers = $this->db->table('users')->where('is_active', 'active')->countAllResults();
        $inactiveUsers = $totalUsers - $activeUsers;
        
        return [
            'total' => $totalUsers,
            'active' => $activeUsers,
            'inactive' => $inactiveUsers,
            'active_percentage' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 2) : 0
        ];
    }
    public function export()
    {
        $type = $this->request->getGet('type');
        
        switch ($type) {
            case 'projects':
                return $this->exportProjects();
            case 'issues':
                return $this->exportIssues();
            case 'staff':
                return $this->exportStaff();
            default:
                return redirect()->back()->with('error', 'Tipe export tidak valid');
        }
    }

    private function exportProjects()
    {
        $projects = $this->db->table('projects p')
            ->select('p.project_name, c.company_name, p.status, p.created_at')
            ->join('companies c', 'c.id = p.company_id', 'left')
            ->get()
            ->getResultArray();
        
        $filename = 'monitoring_projects_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['No', 'Nama Proyek', 'Perusahaan', 'Status', 'Tanggal Dibuat']);
        
        foreach ($projects as $i => $project) {
            fputcsv($output, [
                $i + 1,
                $project['project_name'],
                $project['company_name'] ?? '-',
                $project['status'],
                $project['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }

    private function exportIssues()
    {
        $issues = $this->db->table('issues i')
            ->select('i.title, p.project_name, i.status, i.priority, i.created_at')
            ->join('projects p', 'p.id = i.project_id')
            ->get()
            ->getResultArray();
        
        $filename = 'monitoring_issues_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['No', 'Title', 'Project', 'Status', 'Priority', 'Created At']);
        
        foreach ($issues as $i => $issue) {
            fputcsv($output, [
                $i + 1,
                $issue['title'],
                $issue['project_name'],
                $issue['status'],
                $issue['priority'],
                $issue['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }

    private function exportStaff()
    {
        $staff = $this->getTopStaff();
        
        $filename = 'monitoring_staff_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['No', 'Nama', 'Posisi', 'Total Issues', 'Completed Issues', 'Completion Rate']);
        
        foreach ($staff as $i => $member) {
            $total = $member['total_issues'] ?? 0;
            $completed = $member['completed_issues'] ?? 0;
            $rate = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
            
            fputcsv($output, [
                $i + 1,
                ($member['first_name'] ?? $member['username']) . ' ' . ($member['last_name'] ?? ''),
                $member['position_name'] ?? '-',
                $total,
                $completed,
                $rate . '%'
            ]);
        }
        
        fclose($output);
        exit;
    }
}