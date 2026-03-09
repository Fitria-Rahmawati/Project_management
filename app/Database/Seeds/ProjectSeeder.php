<?php
// app/Database/Seeds/ProjectSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'project_name' => 'Website Company Profile',
                'description' => 'Pembuatan website company profile perusahaan',
                'start_date' => '2024-01-01',
                'end_date' => '2024-03-31',
                'project_type' => 'internal',
                'company_id' => 1,
                'project_manager_id' => $this->getUserId('admin'),
                'status' => 'in_progress',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'project_name' => 'Aplikasi Mobile Maju Jaya',
                'description' => 'Pengembangan aplikasi mobile untuk manajemen inventori',
                'start_date' => '2024-02-01',
                'end_date' => '2024-05-31',
                'project_type' => 'client',
                'company_id' => 2,
                'project_manager_id' => $this->getUserId('admin'),
                'status' => 'in_progress',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'project_name' => 'E-commerce Kreatif Digital',
                'description' => 'Pembuatan platform e-commerce',
                'start_date' => '2024-03-01',
                'end_date' => '2024-06-30',
                'project_type' => 'client',
                'company_id' => 3,
                'project_manager_id' => $this->getUserId('budi_frontend'),
                'status' => 'planning',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            [
                'project_name' => 'Sistem Inventory Belanja Online',
                'description' => 'Pengembangan sistem manajemen inventory',
                'start_date' => '2024-04-01',
                'end_date' => '2024-07-31',
                'project_type' => 'client',
                'company_id' => 4,
                'project_manager_id' => $this->getUserId('rina_backend'),
                'status' => 'planning',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
  
            [
                'project_name' => 'Aplikasi Android Mitra Usaha',
                'description' => 'Pengembangan aplikasi Android manajemen pelanggan',
                'start_date' => '2024-05-01',
                'end_date' => '2024-08-31',
                'project_type' => 'client',
                'company_id' => 5,
                'project_manager_id' => $this->getUserId('siti_android'),
                'status' => 'proposed',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('projects')->insertBatch($data);
    }

    private function getUserId($username)
    {
        $user = $this->db->table('users')->select('id')->where('username', $username)->get()->getRow();
        return $user ? $user->id : null;
    }
}