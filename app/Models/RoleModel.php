<?php


namespace App\Models;
use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    
    public function getPermissions($roleId)
    {
        return $this->select('permissions.*')
            ->join('role_permissions', 'role_permissions.role_id = roles.id')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('roles.id', $roleId)
            ->findAll();
    }

   
    public function hasPermission($roleId, $permissionSlug)
    {
        $result = $this->select('permissions.id')
            ->join('role_permissions', 'role_permissions.role_id = roles.id')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('roles.id', $roleId)
            ->where('permissions.slug', $permissionSlug)
            ->first();
        
        return $result !== null;
    }
}