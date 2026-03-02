<?php

namespace App\Models;
use CodeIgniter\Model;

class IssueModel extends Model
{
    protected $table = 'issues';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id','title','description',
        'priority','status',
        'reported_by','assigned_to',
        'created_at','updated_at'
    ];
    protected $useTimestamps = true;
}