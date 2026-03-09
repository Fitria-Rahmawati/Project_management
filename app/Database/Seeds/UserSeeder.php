<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
  
            [
                'username' => 'superadmin',
                'email' => 'superadmin@internalcompany.com',
                'password' => password_hash('superadmin123', PASSWORD_BCRYPT),
                'role_id' => 1,
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            [
                'username' => 'admin',
                'email' => 'admin@internalcompany.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'role_id' => 2,
                'company_id' => 1, 
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($data as $user) {
            $this->db->table('users')->insert($user);
        }

        $staffData = [
            [
                'username' => 'budi_frontend',
                'email' => 'budi.frontend@internalcompany.com',
                'password' => password_hash('staff123', PASSWORD_BCRYPT),
                'role_id' => 4,
                'company_id' => 1, 
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'rina_backend',
                'email' => 'rina.backend@internalcompany.com',
                'password' => password_hash('staff123', PASSWORD_BCRYPT),
                'role_id' => 4,
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'doni_uiux',
                'email' => 'doni.uiux@internalcompany.com',
                'password' => password_hash('staff123', PASSWORD_BCRYPT),
                'role_id' => 4,
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'siti_android',
                'email' => 'siti.android@internalcompany.com',
                'password' => password_hash('staff123', PASSWORD_BCRYPT),
                'role_id' => 4,
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'ahmad_ios',
                'email' => 'ahmad.ios@internalcompany.com',
                'password' => password_hash('staff123', PASSWORD_BCRYPT),
                'role_id' => 4,
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($staffData as $staff) {
            $this->db->table('users')->insert($staff);
        }

        $clientData = [
            [
                'username' => 'budi_majujaya',
                'email' => 'budi@majujaya.com',
                'password' => password_hash('client123', PASSWORD_BCRYPT),
                'role_id' => 3,
                'company_id' => 2, 
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'dewi_kreatif',
                'email' => 'dewi@kreatifdigital.com',
                'password' => password_hash('client123', PASSWORD_BCRYPT),
                'role_id' => 3,
                'company_id' => 3, 
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'ahmad_belanja',
                'email' => 'ahmad@belanjaonline.com',
                'password' => password_hash('client123', PASSWORD_BCRYPT),
                'role_id' => 3,
                'company_id' => 4, 
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'rini_mitra',
                'email' => 'rini@mitrausaha.com',
                'password' => password_hash('client123', PASSWORD_BCRYPT),
                'role_id' => 3,
                'company_id' => 5, 
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($clientData as $client) {
            $this->db->table('users')->insert($client);
        }
    }
}