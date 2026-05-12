<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TaskDeadlineNotification extends BaseCommand
{
    protected $group = 'Notifications';
    protected $name = 'task:deadline';
    protected $description = 'Kirim notifikasi deadline task yang mendekat dan overdue';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        helper('email');
        helper('notification');
        helper('url');
        
        CLI::write('🔔 Memulai notifikasi deadline task...', 'blue');
        
        // 1. DEADLINE H-2
        $this->checkUpcomingDeadline($db);
        
        // 2. TASK OVERDUE
        $this->checkOverdueTasks($db);
        
        CLI::write('✅ Notifikasi deadline task selesai!', 'green');
    }
    
    private function checkUpcomingDeadline($db)
    {
        $date = date('Y-m-d', strtotime('+2 days'));
        $tasks = $db->table('issues i')
            ->select('i.*, p.project_name, assignee.username, assignee.email, assignee.id as assignee_id')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users assignee', 'assignee.id = i.assignee_id')
            ->where('i.due_date', $date)
            ->where('i.status !=', 'Done')
            ->where('i.status !=', 'Closed')
            ->get()
            ->getResultArray();
        
        if (empty($tasks)) return;
        
        CLI::write("📧 Mengirim notifikasi deadline task (H-2)...", 'yellow');
        
        foreach ($tasks as $task) {
            $message = "
                <div class='content-box warning'>
                    <p><strong>⚠️ Deadline Task Mendekat!</strong></p>
                    <p>Task berikut akan jatuh tempo dalam <strong>2 hari</strong>.</p>
                </div>
                <ul class='info-list'>
                    <li><strong>Task:</strong> <span>{$task['title']}</span></li>
                    <li><strong>Proyek:</strong> <span>{$task['project_name']}</span></li>
                    <li><strong>Deadline:</strong> <span>" . date('d/m/Y', strtotime($task['due_date'])) . "</span></li>
                    <li><strong>Status:</strong> <span>{$task['status']}</span></li>
                </ul>
                <p>Segera selesaikan task sebelum deadline.</p>
            ";
            
            sendEmail($task['email'], '⚠️ Deadline Task Mendekat (2 Hari Lagi)', $message, [
                'userName' => $task['username'],
                'buttonText' => 'Lihat Task',
                'buttonLink' => base_url("staff/tasks/{$task['id']}")
            ], 'task_deadline_soon');
            
            sendNotification($task['assignee_id'], 'task_deadline', '⚠️ Deadline Mendekat', 
                "Task '{$task['title']}' deadline dalam 2 hari", base_url("staff/tasks/{$task['id']}"));
            
            CLI::write("  ✓ Email ke: {$task['email']}", 'green');
        }
    }
    
    private function checkOverdueTasks($db)
    {
        $tasks = $db->table('issues i')
            ->select('i.*, p.project_name, assignee.username, assignee.email, assignee.id as assignee_id')
            ->join('projects p', 'p.id = i.project_id')
            ->join('users assignee', 'assignee.id = i.assignee_id')
            ->where('i.due_date <', date('Y-m-d'))
            ->where('i.status !=', 'Done')
            ->where('i.status !=', 'Closed')
            ->get()
            ->getResultArray();
        
        if (empty($tasks)) return;
        
        CLI::write("📧 Mengirim notifikasi task overdue...", 'yellow');
        
        foreach ($tasks as $task) {
            $daysOverdue = (strtotime(date('Y-m-d')) - strtotime($task['due_date'])) / (60 * 60 * 24);
            
            $message = "
                <div class='content-box danger'>
                    <p><strong>❌ Task Melewati Deadline!</strong></p>
                    <p>Task berikut telah melewati deadline <strong>" . round($daysOverdue) . " hari</strong> yang lalu.</p>
                </div>
                <ul class='info-list'>
                    <li><strong>Task:</strong> <span>{$task['title']}</span></li>
                    <li><strong>Proyek:</strong> <span>{$task['project_name']}</span></li>
                    <li><strong>Deadline:</strong> <span>" . date('d/m/Y', strtotime($task['due_date'])) . "</span></li>
                    <li><strong>Keterlambatan:</strong> <span>" . round($daysOverdue) . " hari</span></li>
                </ul>
                <p>Segera update status task ini.</p>
            ";
            
            sendEmail($task['email'], '❌ Task Melewati Deadline', $message, [
                'userName' => $task['username'],
                'buttonText' => 'Update Status',
                'buttonLink' => base_url("staff/tasks/{$task['id']}")
            ], 'task_overdue');
            
            sendNotification($task['assignee_id'], 'task_overdue', '❌ Task Overdue', 
                "Task '{$task['title']}' terlambat " . round($daysOverdue) . " hari", base_url("staff/tasks/{$task['id']}"));
            
            // Kirim ke admin
            $admins = $db->table('users')->where('role', 'admin')->get()->getResultArray();
            foreach ($admins as $admin) {
                sendEmail($admin['email'], '❌ Task Overdue - Perlu Perhatian', $message, [
                    'userName' => $admin['username'],
                    'buttonText' => 'Lihat Task',
                    'buttonLink' => base_url("admin/issues/{$task['id']}")
                ], 'task_overdue_admin');
            }
            
            CLI::write("  ✓ Email ke: {$task['email']} (terlambat " . round($daysOverdue) . " hari)", 'green');
        }
    }
}