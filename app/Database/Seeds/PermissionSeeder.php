<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin & Superadmin
            ['name' => 'Kelola User', 'slug' => 'manage_users', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Proyek', 'slug' => 'manage_projects', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Perusahaan', 'slug' => 'manage_companies', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Role & Hak Akses', 'slug' => 'manage_roles_permissions', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Monitoring Sistem', 'slug' => 'monitor_system', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Laporan', 'slug' => 'manage_reports', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Team', 'slug' => 'manage_teams', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Anggota Team', 'slug' => 'manage_team_members', 'created_at' => date('Y-m-d H:i:s')],
            
            // Staff
            ['name' => 'Lihat Proyek', 'slug' => 'view_projects', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Update Progres', 'slug' => 'update_progress', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Laporan', 'slug' => 'view_reports', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Progres Proyek', 'slug' => 'view_project_progress', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lapor Issue', 'slug' => 'report_issue', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Tugas', 'slug' => 'manage_tasks', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Tugas', 'slug' => 'view_tasks', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Issue', 'slug' => 'view_issues', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kelola Issue', 'slug' => 'manage_issues', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Team', 'slug' => 'view_teams', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Anggota Team', 'slug' => 'view_team_members', 'created_at' => date('Y-m-d H:i:s')],
            
            // Client
            ['name' => 'Lihat Monitoring', 'slug' => 'view_monitoring', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Laporan Proyek', 'slug' => 'view_project_reports', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Laporan Issue', 'slug' => 'view_issue_reports', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Laporan Tugas', 'slug' => 'view_task_reports', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Laporan Sistem', 'slug' => 'view_system_reports', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Lihat Laporan Progres', 'slug' => 'view_progress_reports', 'created_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($data as $item) {
            $exists = $this->db->table('permissions')
                               ->where('slug', $item['slug'])
                               ->get()
                               ->getRow();
            
            if (!$exists) {
                $this->db->table('permissions')->insert($item);
                echo "  ✓ Insert: {$item['name']}\n";
            } else {
                echo "  ⚠ Skip (already exists): {$item['name']}\n";
            }
        }
    }
}