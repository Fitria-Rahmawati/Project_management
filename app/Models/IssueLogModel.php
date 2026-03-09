<?php

namespace App\Models;
use CodeIgniter\Model;

class IssueLogModel extends Model
{
    protected $table = 'issue_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'issue_id',
        'user_id',
        'field_name',
        'old_value',
        'new_value',
        'comment',
        'created_at'
    ];
    protected $useTimestamps = false;
    protected $createdField = false;
    protected $updatedField = false;

    public function issue()
    {
        return $this->belongsTo('App\Models\IssueModel', 'issue_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }
}