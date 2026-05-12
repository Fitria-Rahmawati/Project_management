<?php

namespace App\Controllers;

class NotificationController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        
        $notifications = $this->db->table('notifications')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        // Update notifikasi menjadi sudah dibaca
        $this->db->table('notifications')
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        
        $data = [
            'title' => 'Notifikasi',
            'notifications' => $notifications
        ];
        
        return view('notifications/index', $data);
    }
    
    public function markAsRead($id)
    {
        $userId = session()->get('user_id');
        
        $this->db->table('notifications')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['is_read' => 1]);
        
        return $this->response->setJSON(['success' => true]);
    }
    
    public function markAllRead()
    {
        $userId = session()->get('user_id');
        
        $this->db->table('notifications')
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        
        return $this->response->setJSON(['success' => true]);
    }
    
    public function getUnreadCount()
    {
        $userId = session()->get('user_id');
        
        $count = $this->db->table('notifications')
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->countAllResults();
        
        return $this->response->setJSON(['count' => $count]);
    }
}