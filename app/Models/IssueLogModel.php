<?php

namespace App\Models;
use CodeIgniter\Model;

class IssueLogModel extends Model
{
    protected $table = 'issue_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'issue_id','old_status','new_status',
        'changed_by','changed_at'
    ];
    public $useTimestamps = false;
}