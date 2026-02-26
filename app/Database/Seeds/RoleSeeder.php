<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'superadmin',
                'description' => 'Akses penuh sistem',
            ],
            [
                'name' => 'admin',
                'description' => 'Admin internal perusahaan',
            ],
            [
                'name' => 'client',
                'description' => 'User perusahaan client',
            ],
            [
                'name' => 'staff',
                'description' => 'Anggota tim proyek',
            ],
        ];

        foreach ($data as $role) {
            $this->db->table('roles')->insert($role);
        }
    }
}
