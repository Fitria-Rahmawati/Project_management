<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class EmailLogs extends BaseCommand
{
    protected $group = 'Testing';
    protected $name = 'email:logs';
    protected $description = 'Lihat log pengiriman email';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        // Cek tabel notification_logs
        if (!$db->tableExists('notification_logs')) {
            CLI::write('❌ Tabel notification_logs belum dibuat!', 'red');
            CLI::write('Jalankan SQL: CREATE TABLE notification_logs...', 'yellow');
            return;
        }
        
        $logs = $db->table('notification_logs')
            ->orderBy('created_at', 'DESC')
            ->limit(20)
            ->get()
            ->getResultArray();
        
        if (empty($logs)) {
            CLI::write('📭 Belum ada log email', 'yellow');
            return;
        }
        
        CLI::write('====================================', 'blue');
        CLI::write('   LOG PENGIRIMAN EMAIL (20 TERAKHIR)', 'white');
        CLI::write('====================================', 'blue');
        
        foreach ($logs as $log) {
            $statusColor = $log['status'] == 'sent' ? 'green' : 'red';
            $statusIcon = $log['status'] == 'sent' ? '✅' : '❌';
            
            CLI::write("\n{$statusIcon} {$log['type']} - {$log['recipient_email']}", 'cyan');
            CLI::write("   Subject: {$log['subject']}", 'white');
            CLI::write("   Status: " . CLI::color($log['status'], $statusColor));
            CLI::write("   Waktu: {$log['created_at']}", 'gray');
            
            if ($log['error_message']) {
                CLI::write("   Error: " . substr($log['error_message'], 0, 200), 'red');
            }
        }
    }
}