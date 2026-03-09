<?php
// app/Database/Seeds/PositionSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $data = [
          
            [
                'position_name' => 'Frontend Developer',
             
                'description'   => 'Mengembangkan tampilan website',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'position_name' => 'Backend Developer',
                
                'description'   => 'Mengembangkan API dan logika server',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'position_name' => 'Fullstack Developer',
                
                'description'   => 'Frontend + Backend',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'position_name' => 'Android Developer',
                'description'   => 'Pengembang aplikasi Android',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'position_name' => 'iOS Developer',
                'description'   => 'Pengembang aplikasi iOS',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            [
                'position_name' => 'UI/UX Designer',
                'description'   => 'Mendesain antarmuka pengguna',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'position_name' => 'Graphic Designer',
                
                'description'   => 'Mendesain grafis dan aset visual',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            [
                'position_name' => 'Project Manager',
                 
                'description'   => 'Mengelola jalannya proyek',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
           
            [
                'position_name' => 'System Administrator',
                
                'description'   => 'Mengelola server dan infrastruktur',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('positions')->insertBatch($data);
    }
}