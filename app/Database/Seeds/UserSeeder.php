<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {        $data = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin@internalcompany.com',
                'password' => password_hash('superadmin123', PASSWORD_BCRYPT),
                'role_id' => 1,
                'company_id' => 1,
                'is_active' => 1,
            ],
            [
                'username' => 'admin',
                'email' => 'admin@internalcompany.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'role_id' => 2,
                'company_id' => 1,
                'is_active' => 1,
            ],
        ];
        foreach ($data as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}
