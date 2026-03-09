<?php
// app/Database/Seeds/IssueSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
   
        $this->db->table('issue_logs')->where('1=1')->delete();
       $this->db->table('issues')->where('1=1')->delete();      
    
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $adminId = $this->getUserId('admin');
        $budiId = $this->getUserId('budi_frontend');
        $rinaId = $this->getUserId('rina_backend');
        $doniId = $this->getUserId('doni_uiux');
        $sitiId = $this->getUserId('siti_android');
        $ahmadId = $this->getUserId('ahmad_ios');
        $budiClientId = $this->getUserId('budi_majujaya');
        $dewiClientId = $this->getUserId('dewi_kreatif');
        $ahmadClientId = $this->getUserId('ahmad_belanja');
        $riniClientId = $this->getUserId('rini_mitra');

        $data = [
            [
                'project_id' => 1,
                'issue_type' => 'task',
                'title' => 'Membuat halaman login',
                'description' => 'Buat halaman login dengan validasi form dan integrasi backend',
                'priority' => 'High',
                'status' => 'Done',
                'reporter_id' => $adminId,
                'assignee_id' => $budiId,
                'parent_issue_id' => null,
                'due_date' => '2024-01-15',
                'estimated_hours' => 8,
                'actual_hours' => 6,
                'created_at' => date('Y-m-d H:i:s', strtotime('-60 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-55 days')),
            ],
            [
                'project_id' => 1,
                'issue_type' => 'task',
                'title' => 'Membuat halaman dashboard',
                'description' => 'Buat dashboard dengan grafik dan informasi ringkasan',
                'priority' => 'High',
                'status' => 'Done',
                'reporter_id' => $adminId,
                'assignee_id' => $budiId,
                'parent_issue_id' => null,
                'due_date' => '2024-01-30',
                'estimated_hours' => 16,
                'actual_hours' => 14,
                'created_at' => date('Y-m-d H:i:s', strtotime('-55 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-45 days')),
            ],
            [
                'project_id' => 1,
                'issue_type' => 'task',
                'title' => 'Membuat API untuk user management',
                'description' => 'Buat REST API untuk CRUD user dengan JWT authentication',
                'priority' => 'High',
                'status' => 'Done',
                'reporter_id' => $adminId,
                'assignee_id' => $rinaId,
                'parent_issue_id' => null,
                'due_date' => '2024-01-20',
                'estimated_hours' => 20,
                'actual_hours' => 18,
                'created_at' => date('Y-m-d H:i:s', strtotime('-58 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-50 days')),
            ],
            [
                'project_id' => 1,
                'issue_type' => 'task',
                'title' => 'Integrasi database dengan Eloquent',
                'description' => 'Setup koneksi database dan model-model yang diperlukan',
                'priority' => 'Medium',
                'status' => 'Done',
                'reporter_id' => $adminId,
                'assignee_id' => $rinaId,
                'parent_issue_id' => null,
                'due_date' => '2024-01-10',
                'estimated_hours' => 12,
                'actual_hours' => 10,
                'created_at' => date('Y-m-d H:i:s', strtotime('-65 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-62 days')),
            ],
            [
                'project_id' => 1,
                'issue_type' => 'task',
                'title' => 'Membuat wireframe halaman utama',
                'description' => 'Buat wireframe untuk homepage, about, contact',
                'priority' => 'High',
                'status' => 'Done',
                'reporter_id' => $adminId,
                'assignee_id' => $doniId,
                'parent_issue_id' => null,
                'due_date' => '2024-01-05',
                'estimated_hours' => 6,
                'actual_hours' => 5,
                'created_at' => date('Y-m-d H:i:s', strtotime('-70 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-68 days')),
            ],
            [
                'project_id' => 1,
                'issue_type' => 'task',
                'title' => 'Desain UI untuk dashboard admin',
                'description' => 'Buat desain high-fidelity untuk dashboard admin',
                'priority' => 'Medium',
                'status' => 'Done',
                'reporter_id' => $adminId,
                'assignee_id' => $doniId,
                'parent_issue_id' => null,
                'due_date' => '2024-01-25',
                'estimated_hours' => 12,
                'actual_hours' => 10,
                'created_at' => date('Y-m-d H:i:s', strtotime('-52 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-48 days')),
            ],

            [
                'project_id' => 1,
                'issue_type' => 'bug',
                'title' => 'Tombol login tidak responsif di mobile',
                'description' => 'Client melaporkan tombol login susah diklik di HP',
                'priority' => 'High',
                'status' => 'In Progress',
                'reporter_id' => $budiClientId,
                'assignee_id' => $budiId,
                'parent_issue_id' => null,
                'due_date' => '2024-03-10',
                'estimated_hours' => 2,
                'actual_hours' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 days')),
            ],
           
            [
                'project_id' => 2,
                'issue_type' => 'task',
                'title' => 'Membuat splash screen',
                'description' => 'Buat splash screen dengan logo perusahaan',
                'priority' => 'Medium',
                'status' => 'Done',
                'reporter_id' => $adminId,
                'assignee_id' => $sitiId,
                'parent_issue_id' => null,
                'due_date' => '2024-02-10',
                'estimated_hours' => 4,
                'actual_hours' => 4,
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-23 days')),
            ],
            [
                'project_id' => 2,
                'issue_type' => 'task',
                'title' => 'Membuat halaman login untuk Android',
                'description' => 'Implementasi halaman login dengan validasi',
                'priority' => 'High',
                'status' => 'In Progress',
                'reporter_id' => $adminId,
                'assignee_id' => $sitiId,
                'parent_issue_id' => null,
                'due_date' => '2024-03-15',
                'estimated_hours' => 12,
                'actual_hours' => 8,
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            [
                'project_id' => 2,
                'issue_type' => 'task',
                'title' => 'Membuat halaman login untuk iOS',
                'description' => 'Implementasi halaman login dengan Swift',
                'priority' => 'High',
                'status' => 'To Do',
                'reporter_id' => $adminId,
                'assignee_id' => $ahmadId,
                'parent_issue_id' => null,
                'due_date' => '2024-03-20',
                'estimated_hours' => 12,
                'actual_hours' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            
            [
                'project_id' => 2,
                'issue_type' => 'bug',
                'title' => 'Aplikasi force close saat buka camera',
                'description' => 'Client melaporkan aplikasi crash saat mencoba mengambil foto',
                'priority' => 'Highest',
                'status' => 'In Progress',
                'reporter_id' => $dewiClientId,
                'assignee_id' => $sitiId,
                'parent_issue_id' => null,
                'due_date' => '2024-03-08',
                'estimated_hours' => 4,
                'actual_hours' => 2,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
           
            [
                'project_id' => 3,
                'issue_type' => 'epic',
                'title' => 'Modul Manajemen Produk',
                'description' => 'Epic untuk semua fitur terkait manajemen produk',
                'priority' => 'High',
                'status' => 'To Do',
                'reporter_id' => $adminId,
                'assignee_id' => null,
                'parent_issue_id' => null,
                'due_date' => '2024-04-30',
                'estimated_hours' => 80,
                'actual_hours' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 days')),
            ],
        ];

        $this->db->table('issues')->insertBatch($data);
        echo "  Issues inserted: " . count($data) . " issues\n";
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