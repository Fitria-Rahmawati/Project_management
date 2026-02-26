<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // superadmin
            ['role_id' => 1, 'permission_id' => 1],
            ['role_id' => 1, 'permission_id' => 2],

            // admin
            ['role_id' => 2, 'permission_id' => 2],

            // client
            ['role_id' => 3, 'permission_id' => 3],

            // staff
            ['role_id' => 4, 'permission_id' => 4],
        ];

        $this->db->table('role_permissions')->insertBatch($data);
    }
}