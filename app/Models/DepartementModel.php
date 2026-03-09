<?php

namespace App\Models;
use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'departement_name','description','created_at','updated_at'
    ];
    protected $useTimestamps = true;
}