<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['slug'];

    public function getGroupedBySlug()
    {
        $permissions = $this->findAll();

        $grouped = [];

        foreach ($permissions as $perm) {
            // users.view → users
            $parts = explode('.', $perm['slug']);
            $group = ucfirst($parts[0]);

            $grouped[$group][] = $perm;
        }

        return $grouped;
    }
}