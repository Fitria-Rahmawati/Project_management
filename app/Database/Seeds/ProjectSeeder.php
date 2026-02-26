<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'project_name' => 'Project Internal A',
                'description' => 'Deskripsi untuk Project Internal A',
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'project_type' => 'internal',
                'company_id' => null, 
                'project_manager_id' => 1, 
            ],
            [
                'project_name' => 'Project Client B',
                'description' => 'Deskripsi untuk Project Client B',
                'start_date' => '2024-02-01',
                'end_date' => '2024-07-31',
                'project_type' => 'client',
                'company_id' => 1, 
                'project_manager_id' => 2, 
            ],
        ];

        foreach ($data as $project) {
            $this->db->table('projects')->insert($project);
        }
    }
}
