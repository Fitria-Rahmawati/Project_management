<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'first_name'    => 'Andi',
                'last_name'     => 'Wijaya',
                'email'         => 'andi@internal.com',
                'phone'         => '08123456789',
                'position_id'   => 1, 
                'department_id' => 1, 
                'company_id'    => 1, 
                'hire_date'     => '2024-01-01',
                'status'        => 'permanent',
            ],
            [
                'first_name'    => 'Budi',
                'last_name'     => 'Santoso',
                'email'         => 'budi@internal.com',
                'phone'         => '08123456788',
                'position_id'   => 2, 
                'department_id' => 1,
                'company_id'    => 1,
                'hire_date'     => '2024-02-01',
                'status'        => 'contract',
            ],
        ];

        $this->db->table('employees')->insertBatch($data);
    }
}