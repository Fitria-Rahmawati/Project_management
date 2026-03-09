<?php
// app/Database/Seeds/EmployeeSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id'       => $this->getUserId('budi_frontend'), 
                'first_name'    => 'Budi',
                'last_name'     => 'Santoso',
                'email'         => 'budi.frontend@internalcompany.com',
                'phone'         => '081234567801',
                'position_id'   => 1, 
                'department_id' => 1, 
                'company_id'    => 1, 
                'hire_date'     => '2024-01-15',
                'status'        => 'permanent',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            [
                'user_id'       => $this->getUserId('rina_backend'),
                'first_name'    => 'Rina',
                'last_name'     => 'Wijaya',
                'email'         => 'rina.backend@internalcompany.com',
                'phone'         => '081234567802',
                'position_id'   => 2, 
                'department_id' => 1, 
                'company_id'    => 1,
                'hire_date'     => '2024-02-01',
                'status'        => 'permanent',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            [
                'user_id'       => $this->getUserId('doni_uiux'),
                'first_name'    => 'Doni',
                'last_name'     => 'Kurniawan',
                'email'         => 'doni.uiux@internalcompany.com',
                'phone'         => '081234567803',
                'position_id'   => 3, 
                'department_id' => 2, 
                'company_id'    => 1,
                'hire_date'     => '2024-01-20',
                'status'        => 'permanent',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            [
                'user_id'       => $this->getUserId('siti_android'),
                'first_name'    => 'Siti',
                'last_name'     => 'Aisyah',
                'email'         => 'siti.android@internalcompany.com',
                'phone'         => '081234567804',
                'position_id'   => 4, 
                'department_id' => 1, 
                'company_id'    => 1,
                'hire_date'     => '2024-03-10',
                'status'        => 'contract',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            [
                'user_id'       => $this->getUserId('ahmad_ios'),
                'first_name'    => 'Ahmad',
                'last_name'     => 'Hidayat',
                'email'         => 'ahmad.ios@internalcompany.com',
                'phone'         => '081234567805',
                'position_id'   => 5, 
                'department_id' => 1, 
                'company_id'    => 1,
                'hire_date'     => '2024-03-15',
                'status'        => 'contract',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            [
                'user_id'       => $this->getUserId('admin'),
                'first_name'    => 'Admin',
                'last_name'     => 'Utama',
                'email'         => 'admin@internalcompany.com',
                'phone'         => '081234567806',
                'position_id'   => 6, 
                'department_id' => 3, 
                'company_id'    => 1,
                'hire_date'     => '2023-01-01',
                'status'        => 'permanent',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('employees')->insertBatch($data);
    }

    private function getUserId($username)
    {
        $user = $this->db->table('users')
                        ->select('id')
                        ->where('username', $username)
                        ->get()
                        ->getRow();
        
        return $user ? $user->id : null;
    }
}