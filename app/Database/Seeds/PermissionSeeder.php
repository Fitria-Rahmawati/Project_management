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
            ['name' => 'Lihat Laporan', 'slug' => 'view_reports'],
            ['name' => 'Kelola Perusahaan', 'slug' => 'manage_companies'],
            ['name' => 'Kelola Role & Hak Akses', 'slug' => 'manage_roles_permissions'],
            ['name' => 'Monitoring Sistem', 'slug' => 'monitor_system'],
            ['name' => 'Lihat Progres Proyek', 'slug' => 'view_project_progress'],
            ['name' => 'Lapor Issue', 'slug' => 'report_issue'],
            ['name' => 'Kelola Tugas', 'slug' => 'manage_tasks'],
            ['name' => 'Lihat Tugas', 'slug' => 'view_tasks'],
            ['name' => 'Lihat Issue', 'slug' => 'view_issues'],
            ['name' => 'Kelola Issue', 'slug' => 'manage_issues'],
            ['name' => 'Lihat Monitoring', 'slug' => 'view_monitoring'],
            ['name' => 'Lihat Laporan Proyek', 'slug' => 'view_project_reports'],
            ['name' => 'Lihat Laporan Issue', 'slug' => 'view_issue_reports'],
            ['name' => 'Lihat Laporan Tugas', 'slug' => 'view_task_reports'],
            ['name' => 'Lihat Laporan Sistem', 'slug' => 'view_system_reports'],
            ['name' => 'Kelola Laporan', 'slug' => 'manage_reports'],
            ['name' => 'Lihat Laporan Progres', 'slug' => 'view_progress_reports'],
            ['name' => 'Kelola Team', 'slug' => 'manage_teams'],
            ['name' => 'Lihat Team', 'slug' => 'view_teams'],
            ['name' => 'Kelola Anggota Team', 'slug' => 'manage_team_members'],
            ['name' => 'Lihat Anggota Team', 'slug' => 'view_team_members']
            
        ];

        $this->db->table('permissions')->insertBatch($data);
    }
}