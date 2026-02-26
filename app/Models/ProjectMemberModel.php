<?php

namespace App\Models;
use CodeIgniter\Model;

class ProjectMemberModel extends Model
{
    protected $table = 'project_members';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id','employee_id','position_id',
        'created_at','updated_at'
    ];
    protected $useTimestamps = true;
}