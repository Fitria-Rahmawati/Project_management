<?php
// app/Database/Seeds/IssueLogSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IssueLogSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        
        $this->db->table('issue_logs')->where('1=1')->delete();
        
        $issues = $this->db->table('issues')->select('id')->get()->getResultArray();
        
        $employee = $this->db->table('employees')
                            ->select('id')
                            ->where('first_name', 'Budi')
                            ->get()
                            ->getRow();
        
        $employeeId = $employee ? $employee->id : 1;
        
        $data = [];
        
        if (isset($issues[0])) {
            $data[] = [
                'issue_id' => $issues[0]['id'],
                'old_status' => 'Open',
                'new_status' => 'In Progress',
                'changed_by' => $employeeId,           
                'changed_at' => date('Y-m-d H:i:s'),  
            ];
        }
        
        if (!empty($data)) {
            $this->db->table('issue_logs')->insertBatch($data);
            echo "  ✅ Issue logs inserted: " . count($data) . " logs\n";
        } else {
            echo "  ⚠ No issue logs inserted\n";
        }
        
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }
}