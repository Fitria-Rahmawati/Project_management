<?php
// app/Database/Seeds/RolePermissionSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $superadmin = $this->db->table('roles')->where('name', 'superadmin')->get()->getRow();
        $admin = $this->db->table('roles')->where('name', 'admin')->get()->getRow();
        $staff = $this->db->table('roles')->where('name', 'staff')->get()->getRow();
        $client = $this->db->table('roles')->where('name', 'client')->get()->getRow();

        $permissions = $this->db->table('permissions')->select('id, slug')->get()->getResultArray();
        
        $permMap = [];
        foreach ($permissions as $p) {
            $permMap[$p['slug']] = $p['id'];
        }

        $data = [];

        if ($superadmin) {
            foreach ($permMap as $slug => $permId) {
                $data[] = [
                    'role_id' => $superadmin->id,
                    'permission_id' => $permId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            echo "  ✓ Superadmin: " . count($permMap) . " permissions\n";
        }

        if ($admin) {
            $adminPermissions = [
                'manage_users',
                'manage_projects',
                'view_projects',
                'update_progress',
                'view_reports',
                'manage_companies',
                'view_project_progress',
                'report_issue',
                'manage_tasks',
                'view_tasks',
                'view_issues',
                'manage_issues',
                'view_monitoring',
                'view_project_reports',
                'view_issue_reports',
                'view_task_reports',
                'view_system_reports',
                'manage_reports',
                'view_progress_reports',
                'manage_teams',
                'view_teams',
                'manage_team_members',
                'view_team_members'
            ];

            foreach ($adminPermissions as $slug) {
                if (isset($permMap[$slug])) {
                    $data[] = [
                        'role_id' => $admin->id,
                        'permission_id' => $permMap[$slug],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            echo "  ✓ Admin: " . count($adminPermissions) . " permissions\n";
        }

        if ($staff) {
            $staffPermissions = [
                'view_projects',
                'update_progress',
                'view_reports',
                'view_project_progress',
                'report_issue',
                'manage_tasks',
                'view_tasks',
                'view_issues',
                'manage_issues',
                'view_teams',
                'view_team_members',
                'view_task_reports'
            ];

            foreach ($staffPermissions as $slug) {
                if (isset($permMap[$slug])) {
                    $data[] = [
                        'role_id' => $staff->id,
                        'permission_id' => $permMap[$slug],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            echo "  ✓ Staff: " . count($staffPermissions) . " permissions\n";
        }


        if ($client) {
            $clientPermissions = [
                'view_monitoring',
                'view_project_reports',
                'view_issue_reports',
                'view_progress_reports'
            ];

            foreach ($clientPermissions as $slug) {
                if (isset($permMap[$slug])) {
                    $data[] = [
                        'role_id' => $client->id,
                        'permission_id' => $permMap[$slug],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            echo "  ✓ Client: " . count($clientPermissions) . " permissions\n";
        }

        if (!empty($data)) {
            $this->db->table('role_permissions')->insertBatch($data);
            echo "  Total " . count($data) . " role_permissions inserted\n";
        }
    }
}