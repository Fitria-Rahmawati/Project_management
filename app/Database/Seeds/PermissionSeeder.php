<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Kelola User', 'slug' => 'manage_users'],
            ['name' => 'Kelola Proyek', 'slug' => 'manage_projects'],
            ['name' => 'Lihat Proyek', 'slug' => 'view_projects'],
            ['name' => 'Update Progres', 'slug' => 'update_progress'],
        ];

        $this->db->table('permissions')->insertBatch($data);
    }
}