<?php
// app/Database/Seeds/ProjectMemberSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectMemberSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'project_id'       => 1,
                'user_id'          => 2,  
                'role_in_project'  => 'project_manager',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
    
            [
                'project_id'       => 1,
                'user_id'          => $this->getUserId('budi_frontend'), 
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'project_id'       => 1,
                'user_id'          => $this->getUserId('rina_backend'),
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'project_id'       => 1,
                'user_id'          => $this->getUserId('doni_uiux'), 
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            
            [
                'project_id'       => 1,
                'user_id'          => $this->getUserId('budi_majujaya'), 
                'role_in_project'  => 'client',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],

            [
                'project_id'       => 2,
                'user_id'          => 2,  
                'role_in_project'  => 'project_manager',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],

            [
                'project_id'       => 2,
                'user_id'          => $this->getUserId('siti_android'), 
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'project_id'       => 2,
                'user_id'          => $this->getUserId('ahmad_ios'), 
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],

            [
                'project_id'       => 2,
                'user_id'          => $this->getUserId('dewi_kreatif'), 
                'role_in_project'  => 'client',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],

            [
                'project_id'       => 3,
                'user_id'          => $this->getUserId('budi_frontend'),
                'role_in_project'  => 'project_manager',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],

            [
                'project_id'       => 3,
                'user_id'          => $this->getUserId('rina_backend'),
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'project_id'       => 3,
                'user_id'          => $this->getUserId('doni_uiux'), 
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
        
            [
                'project_id'       => 3,
                'user_id'          => $this->getUserId('ahmad_belanja'), 
                'role_in_project'  => 'client',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],

            [
                'project_id'       => 4,
                'user_id'          => $this->getUserId('rina_backend'), 
                'role_in_project'  => 'project_manager',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            
            [
                'project_id'       => 4,
                'user_id'          => $this->getUserId('budi_frontend'),
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'project_id'       => 4,
                'user_id'          => $this->getUserId('siti_android'),
                'role_in_project'  => 'staff',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            
            [
                'project_id'       => 4,
                'user_id'          => $this->getUserId('rini_mitra'), 
                'role_in_project'  => 'client',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('project_members')->insertBatch($data);

       
        $members = $this->db->table('project_members')
                            ->select('project_members.id, users.username, project_members.project_id')
                            ->join('users', 'users.id = project_members.user_id')
                            ->where('project_members.role_in_project', 'staff')
                            ->get()
                            ->getResultArray();

        $positionData = [];
      
        foreach ($members as $member) {
            $position_id = null;
            
            if ($member['username'] == 'budi_frontend') {
                $position_id = 1; 
            } elseif ($member['username'] == 'rina_backend') {
                $position_id = 2; 
            } elseif ($member['username'] == 'doni_uiux') {
                $position_id = 7;
            } elseif ($member['username'] == 'siti_android') {
                $position_id = 4; 
            } elseif ($member['username'] == 'ahmad_ios') {
                $position_id = 5; 
            }
            
            if ($position_id) {
                $positionData[] = [
                    'project_member_id' => $member['id'],
                    'position_id'       => $position_id,
                    'created_at'        => date('Y-m-d H:i:s'),
                ];
            }
        }

        if (!empty($positionData)) {
            $this->db->table('project_staff_positions')->insertBatch($positionData);
        }
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