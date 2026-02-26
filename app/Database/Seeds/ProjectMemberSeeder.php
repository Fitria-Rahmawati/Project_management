<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectMemberSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'project_id' => 1,
                'employee_id' => 1,
                'position_id' => 1, // Project Manager
            ],
            [
                'project_id' => 1,
                'employee_id' => 2,
                'position_id' => 2, // Developer
            ],
        ];

        foreach ($data as $member) {
            $this->db->table('project_members')->insert($member);
        }
    }
}
