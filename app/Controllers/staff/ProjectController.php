<?php

namespace App\Controllers\Staff;

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
        $userId = session()->get('user_id');

        $projects = $this->db->table('project_members pm')
            ->select('p.*')
            ->join('projects p', 'p.id = pm.project_id')
            ->where('pm.user_id', $userId)
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

        return view('staff/projects/index', $data);
    }

    public function show($id)
    {
        $userId = session()->get('user_id');

        // Cek apakah staff terlibat di project ini
        $isMember = $this->db->table('project_members')
            ->where('project_id', $id)
            ->where('user_id', $userId)
            ->countAllResults();

        if (!$isMember) {
            return redirect()->to('/staff/projects')->with('error', 'Anda tidak memiliki akses ke proyek ini');
        }

        $project = $this->db->table('projects')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        // Ambil tasks dalam project yang diassign ke staff ini
        $tasks = $this->db->table('issues')
            ->where('project_id', $id)
            ->where('assignee_id', $userId)
            ->whereIn('issue_type', ['task', 'bug', 'story'])
            ->orderBy('due_date', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Project Detail',
            'project' => $project,
            'tasks' => $tasks
        ];

        return view('staff/projects/show', $data);
    }
}