<?php 
namespace App\Models;
use CodeIgniter\Model;
class CompanyModel extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'company_name',
        'company_type',
        'contact_person',
        'email',
        'phone',
        'is_active',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
}