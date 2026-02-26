<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'department_name' => 'IT',
                'description' => 'Departemen Teknologi Informasi',
            ],
            [
                'department_name' => 'HRD',
                'description' => 'Departemen Sumber Daya Manusia',
            ],
        ];

        $this->db->table('departments')->insertBatch($data);
    }
}
