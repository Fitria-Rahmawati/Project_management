<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permissions';
    protected $allowedFields = ['role_id', 'permission_id'];

    public function getPermissionsByRole($roleId)
    {
        return $this->select('permissions.name')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', $roleId)
            ->findAll();
    }

    public function getPermissionIdsByRole($roleId)
    {
        return array_column(
            $this->where('role_id', $roleId)->findAll(),
            'permission_id'
        );
    }
}