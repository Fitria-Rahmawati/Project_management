<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestEmail extends BaseCommand
{
    protected $group = 'Testing';
    protected $name = 'test:email';
    protected $description = 'Test konfigurasi dan kirim email';

    public function run(array $params)
    {
        helper('email');
        
        CLI::write('====================================', 'blue');
        CLI::write('   TEST KONFIGURASI EMAIL', 'white');
        CLI::write('====================================', 'blue');
        
        // Cek konfigurasi
        $config = new \Config\Email();
        
        CLI::write("\n📧 KONFIGURASI EMAIL:", 'yellow');
        CLI::write("  SMTP Host: " . ($config->SMTPHost ?: '❌ KOSONG'), $config->SMTPHost ? 'green' : 'red');
        CLI::write("  SMTP User: " . ($config->SMTPUser ?: '❌ KOSONG'), $config->SMTPUser ? 'green' : 'red');
        CLI::write("  SMTP Pass: " . (strlen($config->SMTPPass) > 0 ? '✅ ADA (' . strlen($config->SMTPPass) . ' karakter)' : '❌ KOSONG'), strlen($config->SMTPPass) > 0 ? 'green' : 'red');
        CLI::write("  SMTP Port: " . ($config->SMTPPort ?: '❌ KOSONG'), $config->SMTPPort ? 'green' : 'red');
        CLI::write("  From Email: " . ($config->fromEmail ?: '❌ KOSONG'), $config->fromEmail ? 'green' : 'red');
        CLI::write("  From Name: " . ($config->fromName ?: '❌ KOSONG'), $config->fromName ? 'green' : 'red');
        
        if (!$config->SMTPHost || !$config->SMTPUser || !$config->SMTPPass || !$config->fromEmail) {
            CLI::write("\n❌ Ada konfigurasi yang kosong! Periksa file .env", 'red');
            return;
        }
        
        CLI::write("\n✅ Konfigurasi lengkap", 'green');
        
        // Minta email tujuan
        CLI::write("\n📧 Masukkan email tujuan test:", 'yellow');
        $testEmail = CLI::prompt('Email', null, 'required|valid_email');
        
        CLI::write("\n⏳ Mengirim email test...", 'yellow');
        
        // Kirim email test
        $result = $this->sendTestEmail($testEmail);
        
        if ($result) {
            CLI::write("\n✅ Email test BERHASIL dikirim ke: {$testEmail}", 'green');
            CLI::write("📌 Cek inbox atau folder SPAM", 'yellow');
        } else {
            CLI::write("\n❌ Email test GAGAL dikirim!", 'red');
            CLI::write("📌 Cek log di: writable/logs/", 'yellow');
        }
    }
    
    private function sendTestEmail($to)
    {
        $message = "
            <div style='font-family: Arial, sans-serif; padding: 20px;'>
                <h2 style='color: #4e73df;'>✅ Test Email Berhasil!</h2>
                <p>Email ini dikirim untuk menguji konfigurasi email pada sistem.</p>
                <hr>
                <p><strong>Waktu pengiriman:</strong> " . date('d/m/Y H:i:s') . "</p>
                <p><strong>Server:</strong> " . $_SERVER['SERVER_NAME'] ?? 'Localhost' . "</p>
                <hr>
                <p>Jika Anda menerima email ini, maka konfigurasi email sudah benar.</p>
            </div>
        ";
        
        return sendEmail($to, '✅ Test Email - PM System', $message, ['userName' => 'Admin'], 'test_email');
    }
}