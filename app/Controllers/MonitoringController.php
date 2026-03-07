<?php

namespace App\Controllers;

class MonitoringController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $projects = $this->db->table('projects')->countAll();
        $issues = $this->db->table('issues')->countAll();
        $users = $this->db->table('users')->countAll();
        $open = $this->db->table('issues')
            ->where('status','open')
            ->countAllResults();
        $progress = $this->db->table('issues')
            ->where('status','progress')
            ->countAllResults();
        $closed = $this->db->table('issues')
            ->where('status','closed')
            ->countAllResults();
        $data = [
            'title' => 'Monitoring Sistem',
            'projects' => $projects,
            'issues' => $issues,
            'users' => $users,
            'open' => $open,
            'progress' => $progress,
            'closed' => $closed
        ];

        return view('superadmin/monitoring/index', $data);
    }
}