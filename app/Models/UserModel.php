<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role_id',
        'company_id',
        'is_active'
    ];

    public function getUsersWithRoleCompany($keyword = null, $companyType = null)
{
    $builder = $this->db->table('users u');
    $builder->select('
        u.id,
        u.username,
        u.email,
        u.is_active,
        r.name AS role_name,
        c.company_name,
        c.company_type
    ');
    $builder->join('roles r', 'r.id = u.role_id');
    $builder->join('companies c', 'c.id = u.company_id', 'left');

    if ($keyword) {
        $builder->groupStart()
                ->like('u.username', $keyword)
                ->orLike('u.email', $keyword)
                ->groupEnd();
    }

    if ($companyType) {
        $builder->where('c.company_type', $companyType);
    }

    return $builder->get()->getResultArray();
}

    public function getUserPermissions($roleId)
    {
        return $this->db->table('role_permissions rp')
            ->select('p.name')
            ->join('permissions p', 'p.id = rp.permission_id')
            ->where('rp.role_id', $roleId)
            ->get()
            ->getResultArray();
    }

public function getUserWithRole($email) 
{
    return $this->select('users.*, roles.name AS role_name')
                ->join('roles', 'roles.id = users.role_id')
                ->where('users.email', $email) 
                ->first();
}
}