<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IssueLogSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'issue_id' => 1,
                'old_status' => 'open',
                'new_status' => 'in_progress',
                'changed_by' => 1,
            ],
            [
                'issue_id' => 2,
                'old_status' => 'open',
                'new_status' => 'in_progress',
                'changed_by' => 1,
            ],
        ];

        $this->db->table('issue_logs')->insertBatch($data);
    }
}
