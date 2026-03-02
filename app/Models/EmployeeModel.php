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
}