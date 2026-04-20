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
        'contract_start',     
        'contract_end',     
        'contract_status',     
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    public function checkContractStatus($companyId)
    {
        $company = $this->find($companyId);
        
        if (!$company || empty($company['contract_end'])) {
            return ['status' => true, 'message' => ''];
        }
        
        $today = strtotime(date('Y-m-d'));
        $endDate = strtotime($company['contract_end']);
   
        if ($today > $endDate) {
            $this->update($companyId, ['contract_status' => 'expired']);
            return [
                'status' => false,
                'message' => 'Kontrak perusahaan sudah berakhir pada tanggal ' . date('d/m/Y', $endDate) . 
                             '. Silakan hubungi admin untuk perpanjangan kontrak.'
            ];
        }
        
        $daysLeft = floor(($endDate - $today) / (60 * 60 * 24));
        
        if ($daysLeft <= 30) {
            $this->update($companyId, ['contract_status' => 'expiring_soon']);
            return [
                'status' => true,
                'message' => 'Kontrak akan berakhir dalam ' . $daysLeft . ' hari. Harap segera perpanjang kontrak.',
                'warning' => true,
                'days_left' => $daysLeft
            ];
        }
      
        if ($company['contract_status'] != 'active') {
            $this->update($companyId, ['contract_status' => 'active']);
        }
        
        return ['status' => true, 'message' => ''];
    }

    public function getExpiringSoonClients()
    {
        return $this->where('contract_end >=', date('Y-m-d'))
                    ->where('contract_end <=', date('Y-m-d', strtotime('+30 days')))
                    ->where('company_type', 'client')
                    ->findAll();
    }

    public function getExpiredClients()
    {
        return $this->where('contract_end <', date('Y-m-d'))
                    ->where('company_type', 'client')
                    ->findAll();
    }

    public function autoUpdateContractStatus()
    {
        $companies = $this->where('company_type', 'client')->findAll();
        $updated = 0;
        
        foreach ($companies as $company) {
            $oldStatus = $company['contract_status'];
            $this->checkContractStatus($company['id']);
            $newStatus = $this->find($company['id'])['contract_status'];
            
            if ($oldStatus != $newStatus) {
                $updated++;
            }
        }
        
        return $updated;
    }
}