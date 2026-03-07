<?php

namespace App\Controllers;

class ReportController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Sistem'
        ];

        return view('admin/reports/index', $data);
    }

    public function generate()
    {
        $type = $this->request->getGet('type');

        if ($type == 'issues') {

            $builder = $this->db->table('issues');

            $builder->select('issues.*, projects.project_name, employees.first_name as employee_name');
            $builder->join('projects', 'projects.id = issues.project_id');
            $builder->join('employees', 'employees.id = issues.assigned_to');

            $data = [
                'title' => 'Laporan Issues',
                'reports' => $builder->get()->getResultArray()
            ];

            return view('admin/reports/result', $data);
        }

        if ($type == 'projects') {

            $data = [
                'title' => 'Laporan Project',
                'reports' => $this->db->table('projects')->get()->getResultArray()
            ];

            return view('admin/reports/result', $data);
        }

        if ($type == 'teams') {

            $builder = $this->db->table('project_members');

            $builder->select('project_members.*, projects.project_name, employees.first_name');
            $builder->join('projects', 'projects.id = project_members.project_id');
            $builder->join('employees', 'employees.id = project_members.employee_id');

            $data = [
                'title' => 'Laporan Tim Project',
                'reports' => $builder->get()->getResultArray()
            ];

            return view('admin/reports/result', $data);
        }
    }
}