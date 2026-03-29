<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 
        'role_id', 'company_id', 'is_active',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

   
    public function role()
    {
        return $this->belongsTo('App\Models\RoleModel', 'role_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\CompanyModel', 'company_id');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\EmployeeModel', 'user_id');
    }

    public function projectMembers()
    {
        return $this->hasMany('App\Models\ProjectMemberModel', 'user_id');
    }

    public function getProjects()
    {
        return $this->hasManyThrough(
            'App\Models\ProjectModel',
            'App\Models\ProjectMemberModel',
            'user_id',
            'id',
            'id',
            'project_id'
        );
    }
    
    public function getFullName()
    {
        $employee = $this->employee;
        return $employee ? $employee->first_name . ' ' . $employee->last_name : $this->username;
    }
        
    public function getAllWithRelations()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.*, roles.name as role_name, companies.company_name');
        $builder->join('roles', 'roles.id = users.role_id', 'left');
        $builder->join('companies', 'companies.id = users.company_id', 'left');
        $builder->orderBy('users.id', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    public function getUsersByRole($roleId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.*, roles.name as role_name, companies.company_name');
        $builder->join('roles', 'roles.id = users.role_id', 'left');
        $builder->join('companies', 'companies.id = users.company_id', 'left');
        
        if ($roleId) {
            $builder->where('users.role_id', $roleId);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getUsersByStatus($isActive)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.*, roles.name as role_name, companies.company_name');
        $builder->join('roles', 'roles.id = users.role_id', 'left');
        $builder->join('companies', 'companies.id = users.company_id', 'left');
        $builder->where('users.is_active', $isActive);
        
        return $builder->get()->getResultArray();
    }

     public function getUsersWithRoleCompany($keyword = null, $companyType = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        
        $builder->select('
            users.*, 
            roles.name as role_name, 
            companies.company_name,
            companies.company_type
        ');
        $builder->join('roles', 'roles.id = users.role_id', 'left');
        $builder->join('companies', 'companies.id = users.company_id', 'left');
        if ($keyword) {
            $builder->groupStart()
                ->like('users.username', $keyword)
                ->orLike('users.email', $keyword)
                ->groupEnd();
        }
        if ($companyType) {
            $builder->where('companies.company_type', $companyType);
        }
        
        $builder->orderBy('users.id', 'DESC');
        
        return $builder->get()->getResultArray();
    }

}
