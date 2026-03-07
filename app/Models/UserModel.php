<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role_id',
        'company_id',
        'is_active'
    ];

    public function getUserWithRole($email)
    {
        return $this->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.email', $email)
            ->first();
    }
    public function getUserWithCompany($email)
    {
        return $this->select('users.*, companies.company_name')
            ->join('companies', 'companies.id = users.company_id')
            ->where('users.email', $email)
            ->first();
    }
    public function getUsersWithRoleCompany()
{
    return $this->select('users.*, roles.name as role_name, companies.company_name')
        ->join('roles', 'roles.id = users.role_id', 'left')
        ->join('companies', 'companies.id = users.company_id', 'left')
        ->findAll();
}
}