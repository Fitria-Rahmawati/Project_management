<?php

namespace App\Models;
use CodeIgniter\Model;

class ProjectMemberModel extends Model
{
    protected $table = 'project_members';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id','employee_id','position_id',
        'created_at','updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
     public function getMembers()
    {
        return $this->select('project_members.*, 
                              projects.project_name, 
                              employees.first_name as employee_name, 
                              positions.position_name as position_name')
                    ->join('projects', 'projects.id = project_members.project_id')
                    ->join('employees', 'employees.id = project_members.employee_id')
                    ->join('positions', 'positions.id = project_members.position_id')
                    ->findAll();
    }
}