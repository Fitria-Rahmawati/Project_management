<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        // Data dasar untuk semua dashboard
        $data = [
            'title' => 'Dashboard',
            'username' => session()->get('username'),
            'full_name' => session()->get('full_name') ?? session()->get('username'),
            'role' => $role
        ];

        // Dashboard ADMIN
        if ($role == 'admin') {
            $data['totalProjects'] = $this->getTotalProjects();
            $data['totalIssues'] = $this->getTotalIssues();
            $data['completedIssues'] = $this->getCompletedIssues();
            $data['overdueIssues'] = $this->getOverdueIssues();
            $data['totalStaff'] = $this->getTotalStaff();
            $data['totalEmployees'] = $this->getTotalEmployees();      
            $data['activeEmployees'] = $this->getActiveEmployees();      
            $data['inProgressProjects'] = $this->getInProgressProjects(); 
            $data['completionRate'] = $this->getCompletionRate();
            $data['issuesByStatus'] = $this->getIssuesByStatus();
            $data['issuesByPriority'] = $this->getIssuesByPriority();
            $data['overdueIssuesList'] = $this->getOverdueIssuesList();
            $data['topStaff'] = $this->getTopStaff();

            return view('dashboard/admin', $data); 
        }

  
        if ($role == 'superadmin') {
            $data['totalUsers'] = $this->getTotalUsers();
            $data['totalProjects'] = $this->getTotalProjects();
            $data['totalIssues'] = $this->getTotalIssues();
            $data['totalCompanies'] = $this->getTotalCompanies();
            $data['activeUsers'] = $this->getActiveUsers();
            return view('dashboard/superadmin', $data);
        }

        if ($role == 'staff') {
            $data['myTasks'] = $this->getMyTasks();
            $data['myProjects'] = $this->getMyProjects();
            return view('dashboard/staff', $data);
        }

        if ($role == 'client') {
            $data['myProjects'] = $this->getClientProjects();
            $data['projectProgress'] = $this->getProjectProgress();
            return view('dashboard/client', $data);
        }

        return redirect()->to('/login');
    }


    private function getTotalUsers()
    {
        $db = \Config\Database::connect();
        return $db->table('users')->countAllResults();
    }

    private function getTotalProjects()
    {
        $db = \Config\Database::connect();
        return $db->table('projects')->countAllResults();
    }

    private function getTotalIssues()
    {
        $db = \Config\Database::connect();
        return $db->table('issues')->countAllResults();
    }

    private function getCompletedIssues()
    {
        $db = \Config\Database::connect();
        return $db->table('issues')
            ->where('status', 'Done')
            ->countAllResults();
    }

    private function getOverdueIssues()
    {
        $db = \Config\Database::connect();
        return $db->table('issues')
            ->where('due_date <', date('Y-m-d'))
            ->where('status !=', 'Done')
            ->where('status !=', 'Closed')
            ->countAllResults();
    }

    private function getTotalStaff()
    {
        $db = \Config\Database::connect();
        return $db->table('users')
            ->where('role_id', 4)
            ->countAllResults();
    }

 
    private function getTotalEmployees()
    {
        $db = \Config\Database::connect();
        return $db->table('employees')->countAllResults();
    }

    private function getActiveEmployees()
    {
        $db = \Config\Database::connect();
        return $db->table('employees')
            ->where('status', 'permanent')
            ->countAllResults();
    }

    private function getInProgressProjects()
    {
        $db = \Config\Database::connect();
        return $db->table('projects')
            ->where('status', 'in_progress')
            ->countAllResults();
    }

    private function getCompletionRate()
    {
        $total = $this->getTotalIssues();
        $completed = $this->getCompletedIssues();
        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }

    private function getIssuesByStatus()
    {
        $db = \Config\Database::connect();
        return $db->table('issues')
            ->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->getResultArray();
    }

    private function getIssuesByPriority()
    {
        $db = \Config\Database::connect();
        return $db->table('issues')
            ->select('priority, COUNT(*) as total')
            ->groupBy('priority')
            ->get()
            ->getResultArray();
    }

    private function getOverdueIssuesList()
    {
        $db = \Config\Database::connect();
        return $db->table('issues i')
            ->select('i.*, p.project_name, assignee.username as assignee_name')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users assignee', 'assignee.id = i.assignee_id', 'left')
            ->where('i.due_date <', date('Y-m-d'))
            ->where('i.status !=', 'Done')
            ->where('i.status !=', 'Closed')
            ->limit(5)
            ->get()
            ->getResultArray();
    }

    private function getTopStaff()
    {
        $db = \Config\Database::connect();
        return $db->table('users u')
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
    }

    private function getMyTasks()
    {
        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        return $db->table('issues')
            ->select('issues.*, projects.project_name')
            ->join('projects', 'projects.id = issues.project_id')
            ->where('assignee_id', $userId)
            ->orderBy('due_date', 'ASC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    private function getMyProjects()
    {
        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        return $db->table('project_members')
            ->select('projects.*, project_members.role_in_project')
            ->join('projects', 'projects.id = project_members.project_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();
    }

    private function getClientProjects()
    {
        $companyId = session()->get('company_id');
        $db = \Config\Database::connect();
        return $db->table('projects')
            ->where('company_id', $companyId)
            ->get()
            ->getResultArray();
    }

    private function getProjectProgress()
    {
        $companyId = session()->get('company_id');
        $db = \Config\Database::connect();
        return $db->table('projects p')
            ->select('
                p.*,
                (SELECT COUNT(*) FROM issues WHERE project_id = p.id) as total_issues,
                (SELECT COUNT(*) FROM issues WHERE project_id = p.id AND status = "Done") as completed_issues
            ')
            ->where('p.company_id', $companyId)
            ->get()
            ->getResultArray();
    }

    private function getActiveUsers()
    {
        $db = \Config\Database::connect();
        return $db->table('users')
            ->where('is_active', 1)
            ->countAllResults();
    }

    private function getTotalCompanies()
    {
        $db = \Config\Database::connect();
        return $db->table('companies')->countAllResults();
    }
}