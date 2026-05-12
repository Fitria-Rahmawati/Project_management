<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ContractNotification extends BaseCommand
{
    protected $group = 'Notifications';
    protected $name = 'contract:notify';
    protected $description = 'Kirim notifikasi kontrak client (expiring, expired, renewed)';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        helper('email');
        
        CLI::write('🔔 Memulai notifikasi kontrak...', 'blue');
        
        // 1. KONTAK AKAN BERAKHIR (H-7, H-3, H-1)
        $this->checkExpiringSoon($db);
        
        // 2. KONTAK SUDAH BERAKHIR
        $this->checkExpired($db);
        
        CLI::write('✅ Notifikasi kontrak selesai!', 'green');
    }
    
    private function checkExpiringSoon($db)
    {
        $days = [7, 3, 1];
        
        foreach ($days as $day) {
            $date = date('Y-m-d', strtotime("+$day days"));
            $clients = $db->table('companies c')
                ->select('c.*, u.email, u.username, u.id as user_id')
                ->join('users u', 'u.id = c.user_id')
                ->where('c.contract_end', $date)
                ->where('c.company_type', 'client')
                ->where('c.is_active', 1)
                ->get()
                ->getResultArray();
            
            if (empty($clients)) continue;
            
            CLI::write("📧 Mengirim notifikasi untuk {$day} hari ke depan...", 'yellow');
            
            foreach ($clients as $client) {
                // Email ke client
                $this->sendToClient($client, $day);
                
                // Email ke admin
                $this->sendToAdmins($db, $client, $day);
                
                // In-app notification
                sendNotification($client['user_id'], 'contract_expiring', '⚠️ Kontrak Akan Berakhir', 
                    "Kontrak Anda akan berakhir dalam {$day} hari. Segera lakukan perpanjangan.", 
                    base_url('client/dashboard'));
                
                CLI::write("  ✓ Email ke: {$client['email']}", 'green');
            }
        }
    }
    
    private function checkExpired($db)
    {
        $date = date('Y-m-d', strtotime('-1 day'));
        $clients = $db->table('companies c')
            ->select('c.*, u.email, u.username, u.id as user_id')
            ->join('users u', 'u.id = c.user_id')
            ->where('c.contract_end', $date)
            ->where('c.company_type', 'client')
            ->where('c.contract_status', 'active')
            ->get()
            ->getResultArray();
        
        if (empty($clients)) return;
        
        CLI::write('📧 Mengirim notifikasi kontrak expired...', 'yellow');
        
        foreach ($clients as $client) {
            // Update status kontrak
            $db->table('companies')->where('id', $client['id'])->update([
                'contract_status' => 'expired',
                'is_active' => 0
            ]);
            $db->table('users')->where('id', $client['user_id'])->update(['is_active' => 0]);
            
            // Email ke client
            $message = "
                <div class='content-box danger'>
                    <p><strong>❌ Kontrak Anda Telah Berakhir</strong></p>
                    <p>Kontrak perusahaan <strong>{$client['company_name']}</strong> telah berakhir pada " . date('d/m/Y', strtotime($client['contract_end'])) . ".</p>
                </div>
                <p><strong>Akibatnya:</strong></p>
                <ul>
                    <li>Akses Anda ke sistem telah dinonaktifkan</li>
                    <li>Proyek yang sedang berjalan akan dihentikan sementara</li>
                </ul>
                <p>Silakan hubungi tim kami untuk perpanjangan kontrak.</p>
            ";
            
            sendEmail($client['email'], '❌ Kontrak Telah Berakhir - Akses Dinonaktifkan', $message, [
                'userName' => $client['username'],
                'buttonText' => 'Hubungi Tim Kami',
                'buttonLink' => base_url('contact')
            ], 'contract_expired');
            
            sendNotification($client['user_id'], 'contract_expired', '❌ Kontrak Berakhir', 
                'Kontrak Anda telah berakhir. Akses sistem dinonaktifkan.', base_url('contact'));
            
            CLI::write("  ✓ Email ke client: {$client['email']}", 'green');
        }
    }
    
    private function sendToClient($client, $daysLeft)
    {
        $message = "
            <div class='content-box warning'>
                <p><strong>⚠️ Peringatan Penting!</strong></p>
                <p>Kontrak perusahaan <strong>{$client['company_name']}</strong> akan berakhir dalam <strong>{$daysLeft} hari</strong>.</p>
            </div>
            <ul class='info-list'>
                <li><strong>Tanggal Mulai:</strong> <span>" . date('d/m/Y', strtotime($client['contract_start'])) . "</span></li>
                <li><strong>Tanggal Berakhir:</strong> <span>" . date('d/m/Y', strtotime($client['contract_end'])) . "</span></li>
                <li><strong>Sisa Hari:</strong> <span>{$daysLeft} hari</span></li>
            </ul>
            <p>Silakan hubungi tim kami untuk perpanjangan kontrak.</p>
        ";
        
        sendEmail($client['email'], "⚠️ Kontrak Akan Berakhir - {$daysLeft} Hari Lagi", $message, [
            'userName' => $client['username'],
            'buttonText' => 'Hubungi Tim Kami',
            'buttonLink' => base_url('contact')
        ], 'contract_expiring');
    }
    
    private function sendToAdmins($db, $client, $daysLeft)
    {
        $admins = $db->table('users')
            ->select('email, username')
            ->where('role', 'admin')
            ->where('is_active', 1)
            ->get()
            ->getResultArray();
        
        foreach ($admins as $admin) {
            $message = "
                <div class='content-box warning'>
                    <p><strong>⚠️ Notifikasi Client</strong></p>
                    <p>Kontrak client <strong>{$client['company_name']}</strong> akan berakhir dalam <strong>{$daysLeft} hari</strong>.</p>
                </div>
                <ul class='info-list'>
                    <li><strong>Perusahaan:</strong> <span>{$client['company_name']}</span></li>
                    <li><strong>Contact Person:</strong> <span>{$client['contact_person']}</span></li>
                    <li><strong>Email:</strong> <span>{$client['email']}</span></li>
                    <li><strong>Telepon:</strong> <span>{$client['phone']}</span></li>
                    <li><strong>Tanggal Berakhir:</strong> <span>" . date('d/m/Y', strtotime($client['contract_end'])) . "</span></li>
                </ul>
            ";
            
            sendEmail($admin['email'], "⚠️ Kontrak Client Akan Berakhir", $message, [
                'userName' => $admin['username'],
                'buttonText' => 'Lihat Detail Client',
                'buttonLink' => base_url("superadmin/companies/{$client['id']}")
            ], 'contract_expiring_admin');
        }
    }
}