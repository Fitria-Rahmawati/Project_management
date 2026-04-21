<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PositionModel;
use App\Models\DepartementModel;
use App\Models\UserModel;

class Employees extends BaseController
{
    protected $employee;
    protected $position;
    protected $department;
    protected $user;
    protected $db;

    public function __construct()
    {
        $this->employee   = new EmployeeModel();
        $this->position   = new PositionModel();
        $this->department = new DepartementModel(); 
        $this->user       = new UserModel();
        helper(['form', 'url']);
        $this->db = \Config\Database::connect();
    }

    // 🔹 List data employee
    public function index()
    {
        $employees = $this->employee
            ->select('employees.*, positions.position_name, departments.department_name, users.username, users.email, users.is_active')
            ->join('positions', 'positions.id = employees.position_id', 'left')
            ->join('departments', 'departments.id = employees.department_id', 'left')  
            ->join('users', 'users.id = employees.user_id', 'left')
            ->findAll();

        // Statistik
        $totalEmployees = count($employees);
        $activeEmployees = 0;
        foreach ($employees as $emp) {
            if ($emp['is_active'] == 1) $activeEmployees++;
        }

        $data = [
            'title' => 'Daftar Karyawan',
            'employees' => $employees,
            'totalEmployees' => $totalEmployees,
            'activeEmployees' => $activeEmployees
        ];

        return view('employees/index', $data);
    }

    // 🔹 Form tambah employee
    public function create()
    {
        $data = [
            'title' => 'Tambah Karyawan',
            'positions' => $this->position->findAll(),
            'departments' => $this->department->findAll()
        ];

        return view('employees/create', $data);
    }

    // 🔹 Simpan employee (dengan akun user)
    public function store()
    {
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'permit_empty|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'phone' => 'permit_empty|max_length[20]',
            'position_id' => 'required',
            'department_id' => 'required',
            'hire_date' => 'required|valid_date',
            'status' => 'required|in_list[permanent,contract,intern,freelance]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->db->transStart();

        // 1. Insert ke tabel users
        $userId = $this->user->insert([
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'staff',
            'role_id' => 4,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Insert ke tabel employees
        $this->employee->insert([
            'user_id' => $userId,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'position_id' => $this->request->getPost('position_id'),
            'department_id' => $this->request->getPost('department_id'),
            'hire_date' => $this->request->getPost('hire_date'),
            'employment_status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 3. Activity log
        $this->db->table('activity_logs')->insert([
            'user_id' => session()->get('user_id'),
            'activity' => 'Menambahkan karyawan: ' . $this->request->getPost('first_name') . ' ' . ($this->request->getPost('last_name') ?? ''),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data karyawan');
        }

        return redirect()->to('/employees')->with('success', 'Karyawan berhasil ditambahkan');
    }

    // 🔹 Form edit employee
    public function edit($id)
    {
        $employee = $this->employee
            ->select('employees.*, users.username, users.email, users.is_active')
            ->join('users', 'users.id = employees.user_id')
            ->where('employees.id', $id)
            ->first();

        if (!$employee) {
            return redirect()->to('/employees')->with('error', 'Karyawan tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Karyawan',
            'employee' => $employee,
            'positions' => $this->position->findAll(),
            'departments' => $this->department->findAll()
        ];

        return view('employees/edit', $data);
    }

    // 🔹 Update employee
    public function update($id)
    {
        $employee = $this->employee->find($id);
        if (!$employee) {
            return redirect()->to('/employees')->with('error', 'Karyawan tidak ditemukan');
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'permit_empty|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
            'position_id' => 'required',
            'department_id' => 'required',
            'hire_date' => 'required|valid_date',
            'employment_status' => 'required|in_list[permanent,contract,intern,freelance]',
            'is_active' => 'required|in_list[0,1]'
        ];

        // Cek unique email jika diubah
        $email = $this->request->getPost('email');
        $currentEmail = $this->user->find($employee['user_id'])['email'] ?? '';
        if ($email != $currentEmail) {
            $rules['email'] = 'required|valid_email|is_unique[users.email]';
        }

        // Cek unique username jika diubah
        $username = $this->request->getPost('username');
        $currentUsername = $this->user->find($employee['user_id'])['username'] ?? '';
        if ($username != $currentUsername) {
            $rules['username'] = 'required|min_length[3]|max_length[50]|is_unique[users.username]';
        }

        // Jika password diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->db->transStart();

        // Update users
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->user->update($employee['user_id'], $userData);

        // Update employees
        $this->employee->update($id, [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'position_id' => $this->request->getPost('position_id'),
            'department_id' => $this->request->getPost('department_id'),
            'hire_date' => $this->request->getPost('hire_date'),
            'employment_status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Activity log
        $this->db->table('activity_logs')->insert([
            'user_id' => session()->get('user_id'),
            'activity' => 'Mengupdate karyawan: ' . $this->request->getPost('first_name') . ' ' . ($this->request->getPost('last_name') ?? ''),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->transComplete();

        return redirect()->to('/employees')->with('success', 'Karyawan berhasil diupdate');
    }

    // 🔹 Hapus employee (soft delete - nonaktifkan)
    public function delete($id)
    {
        $employee = $this->employee->find($id);
        if (!$employee) {
            return redirect()->to('/employees')->with('error', 'Karyawan tidak ditemukan');
        }

        // Cek apakah ada tugas aktif
        $activeTasks = $this->db->table('issues')
            ->where('assignee_id', $employee['user_id'])
            ->where('status !=', 'done')
            ->countAllResults();

        if ($activeTasks > 0) {
            return redirect()->to('/employees')->with('error', 'Karyawan masih memiliki ' . $activeTasks . ' tugas aktif. Tidak bisa dihapus.');
        }

        // Soft delete: nonaktifkan user
        $this->user->update($employee['user_id'], [
            'is_active' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Activity log
        $this->db->table('activity_logs')->insert([
            'user_id' => session()->get('user_id'),
            'activity' => 'Menonaktifkan karyawan: ' . ($employee['first_name'] . ' ' . ($employee['last_name'] ?? '')),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/employees')->with('success', 'Karyawan berhasil dinonaktifkan');
    }

    // 🔹 Detail karyawan
    // 🔹 Detail karyawan
public function show($id)
{
    $employee = $this->employee
        ->select('employees.*, employees.status, positions.position_name, departments.department_name, users.username, users.email, users.is_active, users.created_at as user_created_at')
        ->join('positions', 'positions.id = employees.position_id', 'left')
        ->join('departments', 'departments.id = employees.department_id', 'left')
        ->join('users', 'users.id = employees.user_id', 'left')
        ->where('employees.id', $id)
        ->first();

    if (!$employee) {
        return redirect()->to('/employees')->with('error', 'Karyawan tidak ditemukan');
    }

    // Hitung statistik tugas
    $totalTasks = $this->db->table('issues')->where('assignee_id', $employee['user_id'])->countAllResults();
    $completedTasks = $this->db->table('issues')->where('assignee_id', $employee['user_id'])->where('status', 'done')->countAllResults();
    $inProgressTasks = $this->db->table('issues')->where('assignee_id', $employee['user_id'])->where('status', 'in_progress')->countAllResults();
    $openTasks = $this->db->table('issues')->where('assignee_id', $employee['user_id'])->where('status', 'open')->countAllResults();
    $overdueTasks = $this->db->table('issues')
        ->where('assignee_id', $employee['user_id'])
        ->where('due_date <', date('Y-m-d'))
        ->where('status !=', 'done')
        ->countAllResults();

    // Tugas terbaru
    $recentTasks = $this->db->table('issues i')
        ->select('i.*, p.project_name')
        ->join('projects p', 'p.id = i.project_id')
        ->where('i.assignee_id', $employee['user_id'])
        ->orderBy('i.created_at', 'DESC')
        ->limit(10)
        ->get()
        ->getResultArray();

    $data = [
        'title' => 'Detail Karyawan',
        'employee' => $employee,
        'totalTasks' => $totalTasks,
        'completedTasks' => $completedTasks,
        'inProgressTasks' => $inProgressTasks,
        'openTasks' => $openTasks,
        'overdueTasks' => $overdueTasks,
        'recentTasks' => $recentTasks
    ];

    return view('employees/show', $data);
}
    // 🔹 Reset password
    public function resetPassword($id)
    {
        $employee = $this->employee->find($id);
        if (!$employee) {
            return redirect()->to('/employees')->with('error', 'Karyawan tidak ditemukan');
        }

        $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

        $this->user->update($employee['user_id'], [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->table('activity_logs')->insert([
            'user_id' => session()->get('user_id'),
            'activity' => 'Mereset password karyawan: ' . ($employee['first_name'] . ' ' . ($employee['last_name'] ?? '')),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Password berhasil direset. Password baru: <strong>' . $newPassword . '</strong>');
    }
}