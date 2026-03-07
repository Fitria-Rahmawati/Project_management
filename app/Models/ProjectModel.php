<?php

namespace App\Models;
use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_name','description','project_type',
        'company_id','project_manager_id',
        'start_date','status','created_at','updated_at'
    ];
    protected $useTimestamps = true;
    public function getAllWithRelation()
    {
        return $this->select('projects.*, employees.first_name as pm_name, companies.company_name')
                    ->join('employees', 'employees.id = projects.project_manager_id', 'left')
                    ->join('companies', 'companies.id = projects.company_id', 'left')
                    ->findAll();
    }

    public function getByIdWithRelation($id)
    {
        return $this->select('projects.*, employees.first_name as pm_name')
                    ->join('employees', 'employees.id = projects.project_manager_id', 'left')
                    ->where('projects.id', $id)
                    ->first();
    }
    public function getDetailProject($id)
{
    return $this->select('projects.*, companies.company_name, employees.name as manager_name')
        ->join('companies', 'companies.id = projects.company_id', 'left')
        ->join('employees', 'employees.id = projects.project_manager_id', 'left')
        ->where('projects.id', $id)
        ->first();
}
}