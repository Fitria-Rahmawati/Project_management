<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;        
use App\Models\EmployeeModel;    
use App\Libraries\Recaptcha;
class AuthController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $employeeModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();          
        $this->employeeModel = new EmployeeModel(); 
        helper('email'); 
    }

    public function login()
    {
        
        if (session()->get('isLoggedIn')) {
            return $this->redirectToDashboard(session()->get('role'));
        }
        
        return view('auth/login');
    }

   public function process()
{
    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $remember = $this->request->getPost('remember');
    $recaptcha = $this->request->getPost('g-recaptcha-response');
    
    // ========== VALIDASI CAPTCHA ==========
    if (empty($recaptcha)) {
        return redirect()->back()->withInput()
            ->with('error', 'Harap verifikasi Captcha terlebih dahulu.');
    }
    
    $secret = getenv('GOOGLE_RECAPTCHA_SECRET_KEY');
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret,
        'response' => $recaptcha,
        'remoteip' => $this->request->getIPAddress()
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    
    if (!$result['success']) {
        return redirect()->back()->withInput()
            ->with('error', 'Validasi Captcha gagal. Silakan coba lagi.');
    }
    // ========== END VALIDASI CAPTCHA ==========
    
    $user = $this->userModel
        ->select('users.*, roles.name as role_name, roles.id as role_id')
        ->join('roles', 'roles.id = users.role_id', 'left')
        ->where('users.email', $email)
        ->orWhere('users.username', $email)  
        ->first();
// ========== TAMBAHKAN VALIDASI KONTRAK UNTUK CLIENT ==========
if ($user['role_name'] == 'client') {
    $companyModel = new \App\Models\CompanyModel();
    $contract = $companyModel->checkContractStatus($user['company_id']);
    
    // Jika kontrak sudah berakhir, tolak login
    if (!$contract['status']) {
        return redirect()->back()->withInput()
            ->with('error', $contract['message']);
    }
    
    // Jika kontrak akan berakhir, simpan peringatan ke session
    if (isset($contract['warning']) && $contract['warning'] === true) {
        session()->setFlashdata('contract_warning', $contract['message']);
    }
}
// ========== END VALIDASI KONTRAK ==========
   // ========== TRACKING LOGIN (PERANGKAT & IP) ==========
        $userAgent = $this->request->getUserAgent()->getAgentString();
        $ipAddress = $this->request->getIPAddress();
        
        // Update last login di tabel users
        $this->userModel->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s'),
            'last_login_device' => substr($userAgent, 0, 255),
            'last_ip' => $ipAddress,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        // Simpan ke history login (user_logins)
        $this->db->table('user_logins')->insert([
            'user_id' => $user['id'],
            'user_agent' => $userAgent,
            'ip_address' => $ipAddress,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        // Cek apakah login dari perangkat baru
        $lastLogins = $this->db->table('user_logins')
            ->where('user_id', $user['id'])
            ->orderBy('created_at', 'DESC')
            ->limit(2)
            ->get()
            ->getResultArray();
        
        $isNewDevice = false;
        if (count($lastLogins) >= 2) {
            $prevLogin = $lastLogins[1];
            if ($prevLogin['user_agent'] != $userAgent || $prevLogin['ip_address'] != $ipAddress) {
                $isNewDevice = true;
            }
        }
        
        // Kirim notifikasi jika login dari perangkat baru
        if ($isNewDevice) {
            $message = "
                <div class='content-box warning'>
                    <p><strong>🔐 Login dari Perangkat Baru</strong></p>
                    <p>Akun Anda baru saja diakses dari perangkat yang belum pernah digunakan sebelumnya.</p>
                </div>
                <ul class='info-list'>
                    <li><strong>Waktu:</strong> " . date('d/m/Y H:i:s') . "</li>
                    <li><strong>IP Address:</strong> {$ipAddress}</li>
                    <li><strong>Browser/Device:</strong> " . substr($userAgent, 0, 200) . "</li>
                </ul>
                <p>Jika Anda tidak merasa melakukan login ini, segera ganti password Anda.</p>
            ";
            
            sendEmail($user['email'], '🔐 Login dari Perangkat Baru', $message, [
                'userName' => $user['username'],
                'buttonText' => 'Ganti Password',
                'buttonLink' => base_url('profile/change-password')
            ], 'new_device_login');
            
            // In-app notification
            $this->db->table('notifications')->insert([
                'user_id' => $user['id'],
                'type' => 'new_device',
                'title' => 'Login dari Perangkat Baru',
                'message' => "Akun Anda diakses dari perangkat baru. IP: {$ipAddress}",
                'link' => base_url('profile/change-password'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        // ========== END TRACKING LOGIN ==========

        $permissions = $this->roleModel->getPermissions($user['role_id']);
        
        $permissionNames = [];
        foreach ($permissions as $perm) {
            $permissionNames[] = $perm['slug'];
        }

        $employee = null;
        if ($user['role_name'] == 'staff' || $user['role_name'] == 'admin') {
            $employee = $this->employeeModel
                ->select('employees.*, positions.position_name, departments.department_name')
                ->join('positions', 'positions.id = employees.position_id', 'left')
                ->join('departments', 'departments.id = employees.department_id', 'left')
                ->where('user_id', $user['id'])
                ->first();
        }

        $sessionData = [
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'email'       => $user['email'],
            'role'        => $user['role_name'],
            'role_id'     => $user['role_id'],
            'company_id'  => $user['company_id'],
            'permissions' => $permissionNames,
            'isLoggedIn'  => true
        ];

        if ($employee) {
            $sessionData['employee_id'] = $employee['id'];
            $sessionData['full_name'] = $employee['first_name'] . ' ' . $employee['last_name'];
            $sessionData['position'] = $employee['position_name'];
            $sessionData['department'] = $employee['department_name'];
        } else {
            if ($user['role_name'] == 'client') {
                $company = $this->db->table('companies')
                    ->where('id', $user['company_id'])
                    ->get()
                    ->getRowArray();
                $sessionData['full_name'] = $company ? $company['company_name'] : $user['username'];
                $sessionData['company_name'] = $company ? $company['company_name'] : '';
            } else {
                $sessionData['full_name'] = $user['username'];
            }
        }

        session()->set($sessionData);

        // Remember me (cookie 30 hari)
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $this->db->table('user_tokens')->insert([
                'user_id' => $user['id'],
                'token' => password_hash($token, PASSWORD_DEFAULT),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            setcookie('remember_token', $token, time() + (86400 * 30), '/', '', false, true);
        }

        return $this->redirectToDashboard($user['role_name']);
    }

    public function logout()
    {
        // Hapus remember me token
        if (isset($_COOKIE['remember_token'])) {
            $this->db->table('user_tokens')->where('token', $_COOKIE['remember_token'])->delete();
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        session()->destroy();
        return redirect()->to('/login');
    }

    // ========== FITUR LUPA PASSWORD ==========
    
    public function forgotPassword()
    {
        return view('auth/forgot_password', ['title' => 'Lupa Password']);
    }

    public function requestReset()
    {
        $email = $this->request->getPost('email');
        
        if (empty($email)) {
            return redirect()->back()->with('error', 'Email wajib diisi');
        }
        
        $user = $this->userModel->where('email', $email)->first();
        
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }
        
        // Hapus token lama
        $this->db->table('password_resets')->where('email', $email)->delete();
        
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $this->db->table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'expires_at' => $expiry,
            'is_used' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $resetLink = base_url("reset-password/{$token}");
        
        $message = "
            <div class='content-box info'>
                <p><strong>🔐 Reset Password</strong></p>
                <p>Kami menerima permintaan untuk mereset password akun Anda.</p>
            </div>
            <p>Klik tombol di bawah untuk mereset password. Link ini berlaku 1 jam.</p>
        ";
        
        sendEmail($email, '🔐 Reset Password - PM System', $message, [
            'userName' => $user['username'],
            'buttonText' => 'Reset Password',
            'buttonLink' => $resetLink
        ], 'password_reset');
        
        return redirect()->to('/login')->with('success', 'Email reset password telah dikirim. Cek inbox Anda.');
    }

    public function resetForm($token)
    {
        $reset = $this->db->table('password_resets')
            ->where('token', $token)
            ->where('is_used', 0)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get()
            ->getRowArray();
        
        if (!$reset) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa');
        }
        
        return view('auth/reset_password', [
            'title' => 'Reset Password',
            'token' => $token,
            'email' => $reset['email']
        ]);
    }

    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        
        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak cocok');
        }
        
        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter');
        }
        
        $reset = $this->db->table('password_resets')
            ->where('token', $token)
            ->where('is_used', 0)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get()
            ->getRowArray();
        
        if (!$reset) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa');
        }
        
        $user = $this->userModel->where('email', $reset['email'])->first();
        
        $this->userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->db->table('password_resets')->where('token', $token)->update(['is_used' => 1]);
        
        // Kirim notifikasi password berhasil diubah
        $message = "
            <div class='content-box success'>
                <p><strong>✅ Password Berhasil Diubah</strong></p>
                <p>Password akun Anda telah berhasil diubah pada " . date('d/m/Y H:i:s') . ".</p>
            </div>
            <p>Jika Anda tidak merasa melakukan perubahan ini, segera hubungi admin.</p>
        ";
        
        sendEmail($user['email'], '✅ Password Berhasil Diubah', $message, [
            'userName' => $user['username'],
            'buttonText' => 'Login Sekarang',
            'buttonLink' => base_url('login')
        ], 'password_changed');
        
        return redirect()->to('/login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    // ========== END FITUR LUPA PASSWORD ==========

    private function redirectToDashboard($role)
    {
        switch ($role) {
            case 'superadmin':
                return redirect()->to('/superadmin/dashboard');
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'staff':
                return redirect()->to('/staff/dashboard');
            case 'client':
                return redirect()->to('/client/dashboard');
            default:
                return redirect()->to('/dashboard');
        }
    }
}