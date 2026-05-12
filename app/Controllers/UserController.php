<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\CompanyModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $companyModel;
    protected $db;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->roleModel    = new RoleModel();
        $this->companyModel = new CompanyModel();
        $this->db = \Config\Database::connect();
        helper('email');
    }

    // ==================== EXISTING METHODS ====================
    
    public function index()
    {
        $keyword     = $this->request->getGet('keyword');
        $companyType = $this->request->getGet('company_type');

        $users = $this->userModel->getUsersWithRoleCompany($keyword, $companyType);

        return view('Superadmin/users/index', [
            'title'      => 'Data User',
            'users'      => $users,
            'keyword'    => $keyword,
            'companyType' => $companyType, 
        ]);
    }

    // ==================== CREATE DENGAN UNDANGAN ====================
    
    public function create()
    {
        // Ambil data untuk form
        $departments = $this->db->table('departments')->orderBy('department_name', 'ASC')->get()->getResultArray();
        $positions = $this->db->table('positions')->orderBy('position_name', 'ASC')->get()->getResultArray();
        
        return view('Superadmin/users/create', [
            'title'       => 'Tambah User',
            'roles'       => $this->roleModel->findAll(),
            'companies'   => $this->companyModel->findAll(),
            'departments' => $departments,
            'positions'   => $positions
        ]);
    }

    public function store()
    {
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'role_id' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $roleId = $this->request->getPost('role_id');
        $role = $this->db->table('roles')->where('id', $roleId)->get()->getRow();
        $roleName = $role ? $role->name : 'staff';
        
        $firstName = $this->request->getPost('first_name');
        $lastName = $this->request->getPost('last_name');
        $email = $this->request->getPost('email');
        
        // Generate username otomatis
        $username = $this->generateUsername($firstName, $lastName, $roleName);
        
        // Generate password acak
        $tempPassword = $this->generateRandomPassword();
        $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);
        
        // Generate token undangan
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->db->transStart();

        // Insert user
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role_id' => $roleId,
            'is_active' => 0,
            'is_verified' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Jika role client, tambahkan company
        if ($roleName == 'client') {
            $companyId = $this->request->getPost('company_id');
            $newCompanyName = $this->request->getPost('new_company_name');
            
            if ($companyId == 'new' && !empty($newCompanyName)) {
                $this->db->table('companies')->insert([
                    'company_name' => $newCompanyName,
                    'company_type' => 'client',
                    'contact_person' => $firstName . ' ' . $lastName,
                    'email' => $email,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $companyId = $this->db->insertID();
            }
            $userData['company_id'] = $companyId ?: null;
        }

        $userId = $this->userModel->insert($userData);

        // Insert employee untuk staff/admin
        if ($roleName == 'staff' || $roleName == 'admin') {
            $this->db->table('employees')->insert([
                'user_id' => $userId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'position_id' => $this->request->getPost('position_id'),
                'department_id' => $this->request->getPost('department_id'),
                'phone' => $this->request->getPost('phone'),
                'hire_date' => $this->request->getPost('hire_date'),
                'status' => 'permanent',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Insert invitation
        $this->db->table('user_invitations')->insert([
            'email' => $email,
            'user_id' => $userId,
            'token' => $token,
            'temp_password' => password_hash($tempPassword, PASSWORD_DEFAULT),
            'expires_at' => $expiry,
            'is_used' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data user');
        }

        // Kirim email undangan
        $this->sendInvitationEmail($email, $username, $firstName, $tempPassword, $token, $roleName);

        return redirect()->to('/superadmin/users')->with('success', 'User berhasil ditambahkan. Email undangan telah dikirim.');
    }

    // ==================== HELPER METHODS ====================
    
    private function generateUsername($firstName, $lastName, $role)
    {
        $firstNameClean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $firstName));
        $lastNameClean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $lastName));
        
        if ($role == 'client') {
            // Client: nama_depan.nama_perusahaan
            $companyId = $this->request->getPost('company_id');
            if ($companyId == 'new') {
                $companyName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $this->request->getPost('new_company_name') ?? ''));
                $username = $firstNameClean . '.' . $companyName;
            } elseif ($companyId) {
                $company = $this->db->table('companies')->where('id', $companyId)->get()->getRow();
                $companyName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $company->company_name ?? ''));
                $username = $firstNameClean . '.' . $companyName;
            } else {
                $username = $firstNameClean;
            }
        } else {
            // Staff/Admin: nama_depan.jabatan
            $positionId = $this->request->getPost('position_id');
            if ($positionId) {
                $position = $this->db->table('positions')->where('id', $positionId)->get()->getRow();
                $positionName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $position->position_name ?? 'staff'));
                $username = $firstNameClean . '.' . $positionName;
            } else {
                $username = $firstNameClean . ($lastNameClean ? '.' . $lastNameClean : '');
            }
        }
        
        // Cek unique
        $original = $username;
        $counter = 1;
        while ($this->userModel->where('username', $username)->first()) {
            $username = $original . $counter++;
        }
        return $username;
    }

    private function generateRandomPassword($length = 10)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%';
        return substr(str_shuffle($chars), 0, $length);
    }

  private function sendInvitationEmail($toEmail, $username, $firstName, $tempPassword, $token, $role)
{
    $email = \Config\Services::email();

    $link = base_url("verify-invitation/{$token}");

    $email->setFrom('spiderpunkers@gmail.com', 'PM System');

    // ✅ INI WAJIB (biar gak error "no recipient")
    $email->setTo($toEmail);

    $email->setSubject('🎉 Undangan Bergabung - PM System');

    $email->setMessage("
        <h3>Halo {$firstName} 👋</h3>
        <p>Akun kamu sudah dibuat.</p>
        <p><b>Username:</b> {$username}</p>
        <p><b>Password:</b> {$tempPassword}</p>
        <p><a href='{$link}'>Klik untuk aktivasi akun</a></p>
    ");

    if ($email->send()) {
        log_message('info', "✅ Email berhasil ke: {$toEmail}");
        return true;
    } else {
        log_message('error', "❌ Email gagal: " . $email->printDebugger(['headers']));
        return false;
    }
}

    public function verifyInvitation($token)
    {
        $invitation = $this->db->table('user_invitations')
            ->where('token', $token)
            ->where('is_used', 0)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get()
            ->getRowArray();

        if (!$invitation) {
            return redirect()->to('/login')->with('error', 'Link undangan tidak valid atau sudah kadaluarsa.');
        }

        $user = $this->userModel->find($invitation['user_id']);
        
        if ($user['is_verified'] == 1) {
            return redirect()->to('/login')->with('success', 'Akun sudah aktif. Silakan login.');
        }

        session()->set('invitation_token', $token);
        session()->set('invitation_user_id', $user['id']);
        session()->set('invitation_username', $user['username']);

        return view('auth/set_password', [
            'title' => 'Aktivasi Akun',
            'token' => $token,
            'username' => $user['username'],
            'email' => $user['email']
        ]);
    }

    public function setPassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm = $this->request->getPost('confirm_password');

        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Password tidak cocok');
        }
        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter');
        }

        $invitation = $this->db->table('user_invitations')
            ->where('token', $token)
            ->where('is_used', 0)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get()
            ->getRowArray();

        if (!$invitation) {
            return redirect()->to('/login')->with('error', 'Link tidak valid');
        }

        $user = $this->userModel->find($invitation['user_id']);

        $this->userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'is_active' => 1,
            'is_verified' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->table('user_invitations')->where('token', $token)->update(['is_used' => 1]);

        session()->remove('invitation_token');
        session()->remove('invitation_user_id');
        session()->remove('invitation_username');

        return redirect()->to('/login')->with('success', 'Akun berhasil diaktifkan. Silakan login.');
    }

    // ==================== EXISTING METHODS (Edit, Update, Delete, Toggle) ====================
    
    public function edit($id)
    {
        return view('Superadmin/users/edit', [
            'title'     => 'Edit User',
            'user'      => $this->userModel->find($id),
            'roles'     => $this->roleModel->findAll(),
            'companies' => $this->companyModel->findAll()
        ]);
    }

    public function update($id)
    {
        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'role_id'    => $this->request->getPost('role_id'),
            'company_id' => $this->request->getPost('company_id'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to('/superadmin/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/superadmin/users');
    }

    public function toggle($id)
    {
        $user = $this->userModel->find($id);
        $this->userModel->update($id, ['is_active' => $user['is_active'] ? 0 : 1]);
        return redirect()->back();
    }

private function testSMTPConnection()
{
    $config = new \Config\Email();
    
    log_message('info', "[SMTP] Testing connection to {$config->SMTPHost}:{$config->SMTPPort}");
    
    $connection = @fsockopen($config->SMTPHost, $config->SMTPPort, $errno, $errstr, 10);
    
    if ($connection) {
        log_message('info', "[SMTP] ✅ Koneksi ke {$config->SMTPHost}:{$config->SMTPPort} BERHASIL");
        fclose($connection);
    } else {
        log_message('error', "[SMTP] ❌ Koneksi ke {$config->SMTPHost}:{$config->SMTPPort} GAGAL: {$errstr}");
    }
}
}