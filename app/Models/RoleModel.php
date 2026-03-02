<?php
Namespace App\Models;
use CodeIgniter\Model;
class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'description',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
}