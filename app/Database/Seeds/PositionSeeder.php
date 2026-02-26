<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'position_name' => 'Project Manager',
                'description' => 'Bertanggung jawab atas perencanaan, pelaksanaan, dan pengawasan proyek.',
            ],
            [
                'position_name' => 'Developer',
                'description' => 'Bertanggung jawab untuk mengembangkan fitur dan menyelesaikan tugas teknis dalam proyek.',
            ],
            [
                'position_name' => 'Designer',
                'description' => 'Bertanggung jawab untuk merancang tampilan dan pengalaman pengguna dalam proyek.',
            ],
            [
                'position_name' => 'Tester',
                'description' => 'Bertanggung jawab untuk melakukan pengujian dan memastikan kualitas produk dalam proyek.',
            ],
                [
                    'position_name' => 'Business Analyst',
                    'description' => 'Bertanggung jawab untuk menganalisis kebutuhan bisnis dan menerjemahkannya ke dalam spesifikasi proyek.',
                ],
                
                [
                    'position_name' => 'QA',
                    'description' => 'Bertanggung jawab untuk memastikan kualitas produk dengan melakukan pengujian.',
                ],
           
        ];

        foreach ($data as $position) {
            $this->db->table('positions')->insert($position);
        }
    }
}
