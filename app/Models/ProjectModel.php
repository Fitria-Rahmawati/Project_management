<?php

namespace App\Models;
use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_name','description','project_type',
        'company_id','project_manager_id',
        'start_date','status','created_at','updated_at'
    ];
    protected $useTimestamps = true;
}