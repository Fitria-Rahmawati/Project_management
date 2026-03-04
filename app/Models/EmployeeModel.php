<?php

namespace App\Models;
use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employees';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position_id',
        'departement_id',
        'hire_date',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    public function getProjectManagers()
    {
        return $this->select('employees.id, employees.first_name')
                    ->join('positions', 'positions.id = employees.position_id')
                    ->where('positions.position_name', 'Project Manager')
                    ->findAll();
    }
}