<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompanieSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_name' => 'PT Internal Company',
                'company_type' => 'internal',
                'contact_person' => 'Super Admin',
                'email' => 'hrd@internalcompany.com',
                'phone' => '021-5550001',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'company_name' => 'PT Maju Jaya',
                'company_type' => 'client',
                'contact_person' => 'Budi Santoso',
                'email' => 'info@majujaya.com',
                'phone' => '021-5551234',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_name' => 'PT Kreatif Digital',
                'company_type' => 'client',
                'contact_person' => 'Dewi Lestari',
                'email' => 'info@kreatifdigital.co.id',
                'phone' => '021-5555678',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_name' => 'PT Belanja Online',
                'company_type' => 'client',
                'contact_person' => 'Ahmad Hidayat',
                'email' => 'info@belanjaonline.com',
                'phone' => '021-5559012',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_name' => 'PT Mitra Usaha',
                'company_type' => 'client',
                'contact_person' => 'Rini Wijaya',
                'email' => 'info@mitrausaha.com',
                'phone' => '021-5553456',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('companies')->insertBatch($data);
    }
}