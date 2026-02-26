<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompanieSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'company_name' => 'PT. Internal Company',
                'company_type' => 'internal',
                'contact_person' => 'John Doe',
                'email' => 'john.doe@internalcompany.com',
            ],
        ];
        foreach ($data as $company) {
            $this->db->table('companies')->insert($company);
        }
    }
}
