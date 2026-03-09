<?php

namespace App\Models;
use CodeIgniter\Model;

class ProjectMemberModel extends Model
{
    protected $table = 'project_members';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id',
        'user_id',           
        'role_in_project',   
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\ProjectModel', 'project_id');
    }

    public function getMembers()
    {
        return $this->select('
                project_members.*,
                projects.project_name,
                users.username,
                users.email,
                users.role_id,
                roles.name as role_name,
                employees.first_name,
                employees.last_name,
                positions.position_name,
                companies.company_name
            ')
            ->join('projects', 'projects.id = project_members.project_id')
            ->join('users', 'users.id = project_members.user_id')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('employees', 'employees.user_id = users.id', 'left')
            ->join('positions', 'positions.id = employees.position_id', 'left')
            ->join('companies', 'companies.id = users.company_id', 'left')
            ->findAll();
    }


    public function getProjectStaff($project_id)
    {
        return $this->where('project_id', $project_id)
                    ->where('role_in_project', 'staff')
                    ->findAll();
    }

    public function getProjectClient($project_id)
    {
        return $this->where('project_id', $project_id)
                    ->where('role_in_project', 'client')
                    ->first();
    }
    
    public function getUserProjects($user_id)
    {
        return $this->select('
                project_members.*,
                projects.project_name,
                projects.start_date,
                projects.end_date,
                projects.status as project_status
            ')
            ->join('projects', 'projects.id = project_members.project_id')
            ->where('user_id', $user_id)
            ->findAll();
    }
}