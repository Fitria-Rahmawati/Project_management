<?php

namespace App\Models;
use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',          
        'first_name', 
        'last_name', 
        'email', 
        'phone',
        'position_id', 
        'department_id', 
        'company_id',
        'hire_date', 
        'status',
        'created_at', 
        'updated_at'
    ];
    protected $useTimestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\PositionModel', 'position_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\DepartmentModel', 'department_id');
    }
    
    public function company()
    {
        return $this->belongsTo('App\Models\CompanyModel', 'company_id');
    }
    
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}