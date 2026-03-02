<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'project_id' => 1,
                'title' => 'Bug pada halaman login',
                'description' => 'Pengguna tidak bisa login dengan akun yang valid.',
                'status' => 'open',
                'created_by' => 1,
                'reported_by' => 1,
            ],
            [
                'project_id' => 1,
                'title' => 'Fitur export data tidak berfungsi',
                'description' => 'Ketika mencoba export data, muncul error 500.',
                'status' => 'open',
                'created_by' => 1,
                'reported_by' => 1,
            ],
        ];

        foreach ($data as $issue) {
            $this->db->table('issues')->insert($issue);
        }
    }
}
