<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

class ProgressController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $companyId = session()->get('company_id');
        $userId = session()->get('user_id');

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
            $project['total_issues'] = $totalIssues;
            $project['completed_issues'] = $completedIssues;
            $project['open_issues'] = $totalIssues - $completedIssues;
        }

        $totalProjects = count($projects);
        $totalProgress = 0;
        $totalIssuesAll = 0;
        $completedIssuesAll = 0;

        foreach ($projects as $p) {
            $totalProgress += $p['progress'];
            $totalIssuesAll += $p['total_issues'];
            $completedIssuesAll += $p['completed_issues'];
        }

        $averageProgress = $totalProjects > 0 ? round($totalProgress / $totalProjects, 2) : 0;
        $overallCompletion = $totalIssuesAll > 0 ? round(($completedIssuesAll / $totalIssuesAll) * 100, 2) : 0;

        $monthlyProgress = $this->getMonthlyProgress($companyId);

        $recentActivities = $this->getRecentActivities($userId);

        $data = [
            'title' => 'Progress Report',
            'projects' => $projects,
            'totalProjects' => $totalProjects,
            'averageProgress' => $averageProgress,
            'overallCompletion' => $overallCompletion,
            'totalIssuesAll' => $totalIssuesAll,
            'completedIssuesAll' => $completedIssuesAll,
            'monthlyProgress' => $monthlyProgress,
            'recentActivities' => $recentActivities
        ];

        return view('client/progress/index', $data);
    }

    public function detail($projectId)
    {
        $companyId = session()->get('company_id');
        $userId = session()->get('user_id');

        $project = $this->db->table('projects')
            ->where('id', $projectId)
            ->where('company_id', $companyId)
            ->get()
            ->getRowArray();

        if (!$project) {
            return redirect()->to('/client/progress')->with('error', 'Proyek tidak ditemukan');
        }

        $totalIssues = $this->db->table('issues')
            ->where('project_id', $projectId)
            ->countAllResults();
        
        $completedIssues = $this->db->table('issues')
            ->where('project_id', $projectId)
            ->where('status', 'Done')
            ->countAllResults();
        
        $project['progress'] = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;
        $project['total_issues'] = $totalIssues;
        $project['completed_issues'] = $completedIssues;
        $project['open_issues'] = $totalIssues - $completedIssues;

        $issuesByStatus = $this->db->table('issues')
            ->select('status, COUNT(*) as total')
            ->where('project_id', $projectId)
            ->groupBy('status')
            ->get()
            ->getResultArray();

        $issuesByPriority = $this->db->table('issues')
            ->select('priority, COUNT(*) as total')
            ->where('project_id', $projectId)
            ->groupBy('priority')
            ->get()
            ->getResultArray();

        $issues = $this->db->table('issues')
            ->select('issues.*, assignee.username as assignee_name')
            ->join('users assignee', 'assignee.id = issues.assignee_id', 'left')
            ->where('project_id', $projectId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $timeline = $this->getProjectTimeline($projectId);

        $data = [
            'title' => 'Progress Detail - ' . $project['project_name'],
            'project' => $project,
            'issuesByStatus' => $issuesByStatus,
            'issuesByPriority' => $issuesByPriority,
            'issues' => $issues,
            'timeline' => $timeline
        ];

        return view('client/progress/detail', $data);
    }

    private function getMonthlyProgress($companyId)
    {
        $db = \Config\Database::connect();
        
        $result = $db->table('issues i')
            ->select('DATE_FORMAT(i.created_at, "%Y-%m") as month, COUNT(*) as total, 
                     SUM(CASE WHEN i.status = "Done" THEN 1 ELSE 0 END) as completed')
            ->join('projects p', 'p.id = i.project_id')
            ->where('p.company_id', $companyId)
            ->groupBy('DATE_FORMAT(i.created_at, "%Y-%m")')
            ->orderBy('month', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        return array_reverse($result);
    }

    private function getRecentActivities($userId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('activity_logs')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    private function getProjectTimeline($projectId)
    {
        $db = \Config\Database::connect();
        
        $timeline = [];
        
        $issues = $db->table('issues')
            ->select('"issue" as type, title as description, created_at, status')
            ->where('project_id', $projectId)
            ->get()
            ->getResultArray();
        
        foreach ($issues as $issue) {
            $timeline[] = [
                'date' => $issue['created_at'],
                'type' => 'issue',
                'description' => 'Kendala baru: ' . $issue['description'],
                'status' => $issue['status']
            ];
        }
        
        $project = $db->table('projects')
            ->select('client_comments as comment, comments_updated_at as date')
            ->where('id', $projectId)
            ->where('client_comments IS NOT NULL')
            ->get()
            ->getRowArray();
        
        if ($project && !empty($project['comment'])) {
            $timeline[] = [
                'date' => $project['date'],
                'type' => 'comment',
                'description' => 'Komentar client: ' . substr($project['comment'], 0, 100),
                'status' => null
            ];
        }
        
        usort($timeline, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        return array_slice($timeline, 0, 20);
    }
}