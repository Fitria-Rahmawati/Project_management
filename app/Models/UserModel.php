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
}