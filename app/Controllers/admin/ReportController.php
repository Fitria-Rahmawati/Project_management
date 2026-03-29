<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\IssueModel;
use App\Models\UserModel;
use App\Models\CompanyModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

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
                e.department_id,
                d.department_name,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id) as assigned_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Done") as completed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Closed") as closed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND due_date < CURDATE() AND status NOT IN ("Done", "Closed")) as overdue_issues,
                (SELECT SUM(actual_hours) FROM issues WHERE assignee_id = u.id) as total_hours
            ')
            ->join('roles r', 'r.id = u.role_id')
            ->join('employees e', 'e.user_id = u.id', 'left')
            ->join('positions pos', 'pos.id = e.position_id', 'left')
            ->join('departments d', 'd.id = e.department_id', 'left')
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

        foreach ($clients as &$client) {
            $total = $client['total_issues'];
            $completed = $client['completed_issues'] + $client['closed_issues'];
            $client['completion_rate'] = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
        }

        $data = [
            'title' => 'Laporan Client',
            'clients' => $clients
        ];

        return view('admin/reports/clients', $data);
    }
    public function export($type)
    {
        switch ($type) {
            case 'team':
                return $this->exportTeamExcel();
            case 'projects':
                return $this->exportProjectsExcel();
            case 'issues':
                return $this->exportIssuesExcel();
            case 'clients':
                return $this->exportClientsExcel();
            default:
                return redirect()->back()->with('error', 'Tipe export tidak valid');
        }
    }
    private function exportTeamExcel()
    {
        $staff = $this->db->table('users u')
            ->select('
                u.id,
                u.username,
                u.email,
                e.first_name,
                e.last_name,
                pos.position_name,
                d.department_name,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id) as assigned_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Done") as completed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Closed") as closed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND due_date < CURDATE() AND status NOT IN ("Done", "Closed")) as overdue_issues,
                (SELECT SUM(actual_hours) FROM issues WHERE assignee_id = u.id) as total_hours
            ')
            ->join('employees e', 'e.user_id = u.id', 'left')
            ->join('positions pos', 'pos.id = e.position_id', 'left')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->where('u.role_id', 4) 
            ->orWhere('u.role_id', 2) 
            ->get()
            ->getResultArray();

        foreach ($staff as &$member) {
            $assigned = $member['assigned_issues'];
            $completed = ($member['completed_issues'] + $member['closed_issues']);
            $member['completion_rate'] = $assigned > 0 ? round(($completed / $assigned) * 100, 2) : 0;
        }
        $totalStaff = count($staff);
        $totalTasks = array_sum(array_column($staff, 'assigned_issues'));
        $totalCompleted = array_sum(array_column($staff, 'completed_issues')) + array_sum(array_column($staff, 'closed_issues'));
        $totalOverdue = array_sum(array_column($staff, 'overdue_issues'));
        $avgCompletion = $totalStaff > 0 ? round(array_sum(array_column($staff, 'completion_rate')) / $totalStaff, 2) : 0;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN KINERJA TIM');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Dicetak: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setSize(10);

        $sheet->setCellValue('A4', 'RINGKASAN STATISTIK');
        $sheet->mergeCells('A4:J4');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE9ECEF');

        $sheet->setCellValue('A5', 'Total Staff');
        $sheet->setCellValue('B5', $totalStaff);
        $sheet->setCellValue('D5', 'Total Tugas');
        $sheet->setCellValue('E5', $totalTasks);
        $sheet->setCellValue('G5', 'Rata-rata Completion');
        $sheet->setCellValue('H5', $avgCompletion . '%');

        $sheet->setCellValue('A6', 'Tugas Selesai');
        $sheet->setCellValue('B6', $totalCompleted);
        $sheet->setCellValue('D6', 'Tugas Terlambat');
        $sheet->setCellValue('E6', $totalOverdue);

        $row = 8;
        $headers = ['No', 'Nama Staff', 'Email', 'Posisi', 'Departemen', 'Total Tugas', 'Selesai', 'Terlambat', 'Completion Rate', 'Jam Kerja'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF4CAF50');
            $sheet->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 9;
        foreach ($staff as $i => $member) {
            $completed = ($member['completed_issues'] + $member['closed_issues']);
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, ($member['first_name'] ?? $member['username']) . ' ' . ($member['last_name'] ?? ''));
            $sheet->setCellValue('C' . $row, $member['email'] ?? '');
            $sheet->setCellValue('D' . $row, $member['position_name'] ?? '-');
            $sheet->setCellValue('E' . $row, $member['department_name'] ?? '-');
            $sheet->setCellValue('F' . $row, $member['assigned_issues'] ?? 0);
            $sheet->setCellValue('G' . $row, $completed);
            $sheet->setCellValue('H' . $row, $member['overdue_issues'] ?? 0);
            $sheet->setCellValue('I' . $row, ($member['completion_rate'] ?? 0) . '%');
            $sheet->setCellValue('J' . $row, ($member['total_hours'] ?? 0) . ' jam');
            
            for ($c = 'A'; $c <= 'J'; $c++) {
                $sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
            
            $rate = $member['completion_rate'] ?? 0;
            if ($rate >= 70) {
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC8E6C9');
            } elseif ($rate >= 50) {
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF9C4');
            } else {
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFCDD2');
            }
            
            $row++;
        }

        $filename = 'laporan_tim_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    private function exportProjectsExcel()
    {
        $projects = $this->db->table('projects p')
            ->select('
                p.id,
                p.project_name,
                p.project_type,
                c.company_name,
                u.username as manager_name,
                p.status,
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN PROGRESS PROYEK');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Dicetak: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:J2');

        $row = 4;
        $headers = ['No', 'Nama Proyek', 'Tipe', 'Client', 'Project Manager', 'Status', 'Total Issues', 'Selesai', 'Terlambat', 'Progress'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF2196F3');
            $sheet->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 5;
        foreach ($projects as $i => $project) {
            $completed = $project['completed_issues'] + $project['closed_issues'];
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $project['project_name']);
            $sheet->setCellValue('C' . $row, $project['project_type'] ?? '-');
            $sheet->setCellValue('D' . $row, $project['company_name'] ?? '-');
            $sheet->setCellValue('E' . $row, $project['manager_name'] ?? '-');
            $sheet->setCellValue('F' . $row, $project['status']);
            $sheet->setCellValue('G' . $row, $project['total_issues']);
            $sheet->setCellValue('H' . $row, $completed);
            $sheet->setCellValue('I' . $row, $project['overdue_issues']);
            $sheet->setCellValue('J' . $row, $project['progress'] . '%');
            
            for ($c = 'A'; $c <= 'J'; $c++) {
                $sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
            
            $status = $project['status'];
            if ($status == 'Done') {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC8E6C9');
            } elseif ($status == 'In Progress') {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF9C4');
            } elseif ($status == 'On Hold') {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFCDD2');
            }
            
            $row++;
        }

        $filename = 'laporan_proyek_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    private function exportIssuesExcel()
    {
        $projectId = $this->request->getGet('project_id');
        $dateFrom = $this->request->getGet('date_from');
        $dateTo = $this->request->getGet('date_to');

        $builder = $this->db->table('issues i');
        $builder->select('
            i.id,
            i.title,
            i.issue_type,
            p.project_name,
            i.status,
            i.priority,
            reporter.username as reporter_name,
            assignee.username as assignee_name,
            i.created_at,
            i.due_date
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

        $issues = $builder->get()->getResultArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN ISSUE');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Dicetak: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:J2');

        $row = 4;
        $headers = ['No', 'Title', 'Type', 'Project', 'Status', 'Priority', 'Reporter', 'Assignee', 'Created Date', 'Due Date'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF9800');
            $sheet->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 5;
        foreach ($issues as $i => $issue) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $issue['title']);
            $sheet->setCellValue('C' . $row, $issue['issue_type']);
            $sheet->setCellValue('D' . $row, $issue['project_name']);
            $sheet->setCellValue('E' . $row, $issue['status']);
            $sheet->setCellValue('F' . $row, $issue['priority']);
            $sheet->setCellValue('G' . $row, $issue['reporter_name']);
            $sheet->setCellValue('H' . $row, $issue['assignee_name']);
            $sheet->setCellValue('I' . $row, $issue['created_at']);
            $sheet->setCellValue('J' . $row, $issue['due_date']);
            
            for ($c = 'A'; $c <= 'J'; $c++) {
                $sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
            
            $priority = $issue['priority'];
            if ($priority == 'High') {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFCDD2');
            } elseif ($priority == 'Medium') {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF9C4');
            } elseif ($priority == 'Low') {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC8E6C9');
            }
            
            $row++;
        }

        $filename = 'laporan_issue_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    private function exportClientsExcel()
    {
        $clients = $this->db->table('companies c')
            ->select('
                c.id,
                c.company_name,
                c.email,
                c.phone,
                c.address,
                (SELECT COUNT(*) FROM projects WHERE company_id = c.id) as total_projects,
                (SELECT COUNT(*) FROM issues i 
                 JOIN projects p ON p.id = i.project_id 
                 WHERE p.company_id = c.id) as total_issues,
                (SELECT COUNT(*) FROM issues i 
                 JOIN projects p ON p.id = i.project_id 
                 WHERE p.company_id = c.id AND i.status = "Done") as completed_issues
            ')
            ->where('c.company_type', 'client')
            ->get()
            ->getResultArray();

        foreach ($clients as &$client) {
            $client['completion_rate'] = $client['total_issues'] > 0 ? round(($client['completed_issues'] / $client['total_issues']) * 100, 2) : 0;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN CLIENT');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Dicetak: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:H2');

        $row = 4;
        $headers = ['No', 'Nama Client', 'Email', 'Telepon', 'Alamat', 'Total Proyek', 'Total Issues', 'Issues Selesai', 'Completion Rate'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF9C27B0');
            $sheet->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 5;
        foreach ($clients as $i => $client) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $client['company_name']);
            $sheet->setCellValue('C' . $row, $client['email']);
            $sheet->setCellValue('D' . $row, $client['phone']);
            $sheet->setCellValue('E' . $row, $client['address']);
            $sheet->setCellValue('F' . $row, $client['total_projects']);
            $sheet->setCellValue('G' . $row, $client['total_issues']);
            $sheet->setCellValue('H' . $row, $client['completed_issues']);
            $sheet->setCellValue('I' . $row, $client['completion_rate'] . '%');
            
            for ($c = 'A'; $c <= 'I'; $c++) {
                $sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
            $row++;
        }

        $filename = 'laporan_client_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function printProjects()
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
            'projects' => $projects,
            'print_date' => date('d/m/Y H:i:s')
        ];

        return view('admin/reports/print/projects_print', $data);
    }

    public function printIssues()
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
            'filters' => [
                'project_id' => $projectId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ],
            'print_date' => date('d/m/Y H:i:s'),
            'projects' => $this->project->findAll()
        ];

        return view('admin/reports/print/issues_print', $data);
    }

    public function printTeam()
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
                e.department_id,
                d.department_name,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id) as assigned_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Done") as completed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND status = "Closed") as closed_issues,
                (SELECT COUNT(*) FROM issues WHERE assignee_id = u.id AND due_date < CURDATE() AND status NOT IN ("Done", "Closed")) as overdue_issues,
                (SELECT SUM(actual_hours) FROM issues WHERE assignee_id = u.id) as total_hours
            ')
            ->join('roles r', 'r.id = u.role_id')
            ->join('employees e', 'e.user_id = u.id', 'left')
            ->join('positions pos', 'pos.id = e.position_id', 'left')
            ->join('departments d', 'd.id = e.department_id', 'left')
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
            'staff' => $staff,
            'print_date' => date('d/m/Y H:i:s'),
            'total_staff' => count($staff),
            'total_tasks' => array_sum(array_column($staff, 'assigned_issues')),
            'total_completed' => array_sum(array_column($staff, 'completed_issues')) + array_sum(array_column($staff, 'closed_issues')),
            'total_overdue' => array_sum(array_column($staff, 'overdue_issues')),
            'avg_completion' => count($staff) > 0 ? round(array_sum(array_column($staff, 'completion_rate')) / count($staff), 1) : 0
        ];

        return view('admin/reports/print/team_print', $data);
    }

    public function printClients()
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

        foreach ($clients as &$client) {
            $total = $client['total_issues'];
            $completed = $client['completed_issues'] + $client['closed_issues'];
            $client['completion_rate'] = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
        }

        $data = [
            'title' => 'Laporan Client',
            'clients' => $clients,
            'print_date' => date('d/m/Y H:i:s'),
            'total_clients' => count($clients),
            'total_projects' => array_sum(array_column($clients, 'total_projects')),
            'total_issues' => array_sum(array_column($clients, 'total_issues'))
        ];

        return view('admin/reports/print/clients_print', $data);
    }
}