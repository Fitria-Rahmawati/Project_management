<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'department_name' => 'IT Development',
                'department_code' => 'IT-DEV',
                'description'     => 'Departemen pengembangan perangkat lunak (web & mobile)',
                'head_position_id' => 8, 
                'parent_id'       => null, 
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'IT Infrastructure',
                'department_code' => 'IT-INF',
                'description'     => 'Departemen infrastruktur, server, dan jaringan',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'IT Support',
                'department_code' => 'IT-SUP',
                'description'     => 'Departemen dukungan teknis dan helpdesk',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],

            [
                'department_name' => 'Creative & Design',
                'department_code' => 'CR-DES',
                'description'     => 'Departemen desain UI/UX dan grafis',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],

            [
                'department_name' => 'Project Management Office',
                'department_code' => 'PMO',
                'description'     => 'Departemen manajemen proyek dan portofolio',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],

            [
                'department_name' => 'Business Development',
                'department_code' => 'BIZ-DEV',
                'description'     => 'Departemen pengembangan bisnis dan client relations',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'Sales & Marketing',
                'department_code' => 'SALES',
                'description'     => 'Departemen penjualan dan pemasaran',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],

            [
                'department_name' => 'Human Resources',
                'department_code' => 'HR',
                'description'     => 'Departemen sumber daya manusia',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'Finance & Accounting',
                'department_code' => 'FIN',
                'description'     => 'Departemen keuangan dan akuntansi',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'Legal & Compliance',
                'department_code' => 'LEGAL',
                'description'     => 'Departemen hukum dan kepatuhan',
                'head_position_id' => 8,
                'parent_id'       => null,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('departments')->insertBatch($data);


        $subDepartments = [
            [
                'department_name' => 'Web Development',
                'department_code' => 'IT-DEV-WEB',
                'description'     => 'Tim pengembangan website',
                'head_position_id' => 8,
                'parent_id'       => 1, 
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'Mobile Development',
                'department_code' => 'IT-DEV-MOB',
                'description'     => 'Tim pengembangan aplikasi mobile',
                'head_position_id' => 8,
                'parent_id'       => 1, 
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'QA & Testing',
                'department_code' => 'IT-DEV-QA',
                'description'     => 'Tim quality assurance dan testing',
                'head_position_id' => 8,
                'parent_id'       => 1, 
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],

            [
                'department_name' => 'UI/UX Design',
                'department_code' => 'CR-DES-UI',
                'description'     => 'Tim desain antarmuka dan pengalaman pengguna',
                'head_position_id' => 8,
                'parent_id'       => 4, 
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'department_name' => 'Graphic Design',
                'department_code' => 'CR-DES-GR',
                'description'     => 'Tim desain grafis dan visual',
                'head_position_id' => 8,
                'parent_id'       => 4,
                'is_active'       => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('departments')->insertBatch($subDepartments);
    }
}