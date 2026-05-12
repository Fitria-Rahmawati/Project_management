<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class WeeklyReport extends BaseCommand
{
    protected $group = 'Reports';
    protected $name = 'report:weekly';
    protected $description = 'Kirim laporan mingguan ke admin dan staff';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        helper('email');
        
        CLI::write('📊 Membuat laporan mingguan...', 'blue');
        
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $weekEnd = date('Y-m-d', strtotime('sunday this week'));
        
        // Statistik
        $stats = [
            'new_projects' => $db->table('projects')->where('created_at >=', $weekStart)->countAllResults(),
            'completed_projects' => $db->table('projects')->where('status', 'completed')->where('updated_at >=', $weekStart)->countAllResults(),
            'new_issues' => $db->table('issues')->where('created_at >=', $weekStart)->countAllResults(),
            'resolved_issues' => $db->table('issues')->where('status', 'Done')->where('updated_at >=', $weekStart)->countAllResults(),
            'active_projects' => $db->table('projects')->where('status', 'in_progress')->countAllResults(),
            'total_tasks' => $db->table('issues')->countAllResults(),
        ];
        
        // Top performers
        $topStaff = $db->table('users u')
            ->select('u.username, COUNT(i.id) as completed_count')
            ->join('issues i', 'i.assignee_id = u.id', 'left')
            ->where('i.status', 'Done')
            ->where('i.updated_at >=', $weekStart)
            ->groupBy('u.id')
            ->orderBy('completed_count', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        // Pesan HTML
        $topList = '';
        if (!empty($topStaff)) {
            foreach ($topStaff as $i => $staff) {
                $topList .= "<li><strong>" . ($i + 1) . ".</strong> {$staff['username']} - <span style='color:#1cc88a;'>{$staff['completed_count']} task selesai</span></li>";
            }
        } else {
            $topList = "<li>Belum ada data</li>";
        }
        
        $message = "
            <h3>📊 Laporan Mingguan</h3>
            <p>Periode: <strong>" . date('d/m/Y', strtotime($weekStart)) . " - " . date('d/m/Y', strtotime($weekEnd)) . "</strong></p>
            
            <div class='content-box'>
                <h4>📈 Ringkasan Performa</h4>
                <ul class='info-list'>
                    <li><strong>Proyek Baru:</strong> <span>{$stats['new_projects']}</span></li>
                    <li><strong>Proyek Selesai:</strong> <span>{$stats['completed_projects']}</span></li>
                    <li><strong>Proyek Aktif:</strong> <span>{$stats['active_projects']}</span></li>
                    <li><strong>Issue Baru:</strong> <span>{$stats['new_issues']}</span></li>
                    <li><strong>Issue Selesai:</strong> <span>{$stats['resolved_issues']}</span></li>
                    <li><strong>Total Task:</strong> <span>{$stats['total_tasks']}</span></li>
                </ul>
            </div>
            
            <h4>🏆 Top Performers Minggu Ini</h4>
            <ul class='info-list'>
                {$topList}
            </ul>
            
            <div class='small-text'>
                <p>Laporan ini dibuat otomatis setiap hari Senin pagi.</p>
            </div>
        ";
        
        // Kirim ke semua admin dan staff
        $recipients = $db->table('users u')
            ->select('u.email, u.username')
            ->whereIn('u.role', ['admin', 'staff'])
            ->where('u.is_active', 1)
            ->get()
            ->getResultArray();
        
        if (!empty($recipients)) {
            CLI::write("📧 Mengirim laporan ke " . count($recipients) . " penerima...", 'yellow');
            
            foreach ($recipients as $recipient) {
                sendEmail($recipient['email'], '📊 Laporan Mingguan - Project Management System', $message, [
                    'userName' => $recipient['username'],
                    'buttonText' => 'Lihat Dashboard',
                    'buttonLink' => base_url('dashboard')
                ], 'weekly_report');
                CLI::write("  ✓ Email ke: {$recipient['email']}", 'green');
            }
        }
        
        CLI::write('✅ Laporan mingguan selesai!', 'green');
    }
}