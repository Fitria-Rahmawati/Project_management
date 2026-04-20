<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'activity', 'created_at'];
    protected $useTimestamps = false;
  
    public function getUserActivities($userId, $limit = 50)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    
    public function log($userId, $activity)
    {
        return $this->insert([
            'user_id' => $userId,
            'activity' => $activity,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}