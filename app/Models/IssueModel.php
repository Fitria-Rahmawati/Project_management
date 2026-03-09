<?php

namespace App\Models;
use CodeIgniter\Model;

class IssueModel extends Model
{
    protected $table = 'issues';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id',
        'issue_type',          
        'title',
        'description',
        'priority',             
        'status',                
        'reporter_id',           
        'assignee_id',           
        'parent_issue_id',       
        'due_date',              
        'estimated_hours',       
        'actual_hours',        
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getProject($issueId)
    {
        $issue = $this->find($issueId);
        if (!$issue) return null;
        
        $projectModel = new \App\Models\ProjectModel();
        return $projectModel->find($issue['project_id']);
    }

    public function getReporter($issueId)
    {
        $issue = $this->find($issueId);
        if (!$issue || !$issue['reporter_id']) return null;
        
        $userModel = new \App\Models\UserModel();
        return $userModel->find($issue['reporter_id']);
    }

    public function getAssignee($issueId)
    {
        $issue = $this->find($issueId);
        if (!$issue || !$issue['assignee_id']) return null;
        
        $userModel = new \App\Models\UserModel();
        return $userModel->find($issue['assignee_id']);
    }

    public function getLogs($issueId)
    {
        $db = \Config\Database::connect();
        return $db->table('issue_logs')
            ->select('issue_logs.*, users.username as user_name')
            ->join('users', 'users.id = issue_logs.changed_by', 'left')
            ->where('issue_id', $issueId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getParent($issueId)
    {
        $issue = $this->find($issueId);
        if (!$issue || !$issue['parent_issue_id']) return null;
        
        return $this->find($issue['parent_issue_id']);
    }

    public function getChildren($issueId)
    {
        return $this->where('parent_issue_id', $issueId)->findAll();
    }

    public function getIssuesWithDetails($filters = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('issues i');
        
        $builder->select('
            i.*,
            p.project_name,
            p.project_type,
            reporter.username as reporter_name,
            assignee.username as assignee_name
        ');
        $builder->join('projects p', 'p.id = i.project_id');
        $builder->join('users reporter', 'reporter.id = i.reporter_id', 'left');
        $builder->join('users assignee', 'assignee.id = i.assignee_id', 'left');
        
        if (!empty($filters['project_id'])) {
            $builder->where('i.project_id', $filters['project_id']);
        }
        if (!empty($filters['issue_type'])) {
            $builder->where('i.issue_type', $filters['issue_type']);
        }
        if (!empty($filters['status'])) {
            $builder->where('i.status', $filters['status']);
        }
        if (!empty($filters['priority'])) {
            $builder->where('i.priority', $filters['priority']);
        }
        if (!empty($filters['assignee_id'])) {
            if ($filters['assignee_id'] == 'unassigned') {
                $builder->where('i.assignee_id IS NULL');
            } else {
                $builder->where('i.assignee_id', $filters['assignee_id']);
            }
        }
        
        $builder->orderBy('i.created_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    public function getIssueWithDetails($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('issues i');
        
        $builder->select('
            i.*,
            p.project_name,
            p.project_type,
            p.start_date,
            p.end_date,
            reporter.username as reporter_name,
            reporter.email as reporter_email,
            assignee.username as assignee_name,
            assignee.email as assignee_email,
            e.first_name,
            e.last_name,
            pos.position_name
        ');
        $builder->join('projects p', 'p.id = i.project_id');
        $builder->join('users reporter', 'reporter.id = i.reporter_id', 'left');
        $builder->join('users assignee', 'assignee.id = i.assignee_id', 'left');
        $builder->join('employees e', 'e.user_id = assignee.id', 'left');
        $builder->join('positions pos', 'pos.id = e.position_id', 'left');
        $builder->where('i.id', $id);
        
        $issue = $builder->get()->getRowArray();
        
        if ($issue) {
            $issue['logs'] = $this->getLogs($id);
            if ($issue['parent_issue_id']) {
                $issue['parent'] = $this->find($issue['parent_issue_id']);
            }
            $issue['children'] = $this->where('parent_issue_id', $id)->findAll();
        }
        
        return $issue;
    }

    public function updateStatus($id, $status, $userId)
    {
        $issue = $this->find($id);
        if (!$issue) return false;
        
        $oldStatus = $issue['status'];
        
        $this->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $db = \Config\Database::connect();
        $db->table('issue_logs')->insert([
            'issue_id' => $id,
            'user_id' => $userId,
            'field_name' => 'status',
            'old_value' => $oldStatus,
            'new_value' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return true;
    }

    public function assignTo($id, $assigneeId, $userId)
    {
        $issue = $this->find($id);
        if (!$issue) return false;
        
        $oldAssignee = $issue['assignee_id'];
        
        $db = \Config\Database::connect();
        $oldName = 'Unassigned';
        if ($oldAssignee) {
            $oldUser = $db->table('users')->select('username')->where('id', $oldAssignee)->get()->getRow();
            $oldName = $oldUser ? $oldUser->username : 'Unassigned';
        }
        
        $newName = 'Unassigned';
        if ($assigneeId) {
            $newUser = $db->table('users')->select('username')->where('id', $assigneeId)->get()->getRow();
            $newName = $newUser ? $newUser->username : 'Unassigned';
        }
        
        $this->update($id, [
            'assignee_id' => $assigneeId ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $db->table('issue_logs')->insert([
            'issue_id' => $id,
            'user_id' => $userId,
            'field_name' => 'assignee',
            'old_value' => $oldName,
            'new_value' => $newName,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return true;
    }
}