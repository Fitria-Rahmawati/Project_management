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
   public function getAllWithRelation($status = null, $type = null, $company = null)
{
    $builder = $this->db->table('projects p');
    $builder->select('
        p.*,
        c.company_name,
        c.company_type,
        u.username as manager_username,
        e.first_name as manager_first_name,
        e.last_name as manager_last_name
    ');
    $builder->join('companies c', 'c.id = p.company_id', 'left');
    $builder->join('users u', 'u.id = p.project_manager_id', 'left');
    $builder->join('employees e', 'e.user_id = u.id', 'left');

    if ($status) {
        $builder->where('p.status', $status);
    }
    if ($type) {
        $builder->where('p.project_type', $type);
    }
    if ($company) {
        $builder->where('p.company_id', $company);
    }

    $builder->orderBy('p.created_at', 'DESC');

    return $builder->get()->getResultArray();
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