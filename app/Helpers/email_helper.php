<?php

use Config\Email;
use CodeIgniter\I18n\Time;

if (!function_exists('sendEmail')) {
    function sendEmail($to, $subject, $message, $data = [], $logType = null)
    {
        $email = \Config\Services::email();
        $config = new Email();
        $db = \Config\Database::connect();
        
        // Multiple recipients
        if (is_array($to)) {
            foreach ($to as $recipient) {
                $email->setTo($recipient);
            }
        } else {
            $email->setTo($to);
        }
        
        $email->initialize($config);
        $email->setFrom($config->fromEmail, $config->fromName);
        $email->setSubject($subject);
        
        // Template HTML
        $template = view('emails/master_template', array_merge([
            'title' => $subject,
            'content' => $message,
            'userName' => $data['userName'] ?? 'User',
            'buttonText' => $data['buttonText'] ?? null,
            'buttonLink' => $data['buttonLink'] ?? null,
            'year' => date('Y'),
            'companyName' => 'PT Vitech Asia'
        ], $data));
        
        $email->setMessage($template);
        $email->setMailType('html');
        
        $status = 'sent';
        $error = null;
        
        if (!$email->send()) {
            $status = 'failed';
            $error = $email->printDebugger(['headers']);
            log_message('error', $error);
        }
        
        // Log ke database
        if ($logType) {
            $db->table('notification_logs')->insert([
                'recipient_email' => is_array($to) ? implode(',', $to) : $to,
                'type' => $logType,
                'subject' => $subject,
                'status' => $status,
                'error_message' => $error,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        return $status === 'sent';
    }
}

if (!function_exists('sendNotification')) {
    function sendNotification($userId, $type, $title, $message, $link = null)
    {
        $db = \Config\Database::connect();
        
        return $db->table('notifications')->insert([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

if (!function_exists('getUnreadNotifications')) {
    function getUnreadNotifications($userId, $limit = 10)
    {
        $db = \Config\Database::connect();
        
        return $db->table('notifications')
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}