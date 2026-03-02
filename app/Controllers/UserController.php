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

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->roleModel    = new RoleModel();
        $this->companyModel = new CompanyModel();
    }

   public function index()
{
    $keyword     = $this->request->getGet('keyword');
    $companyType = $this->request->getGet('company_type');

    $users = $this->userModel->getUsersWithRoleCompany($keyword, $companyType);

    return view('Superadmin/users/index', [
        'title'      => 'Data User',
        'users'       => $users,
        'keyword'     => $keyword,
        'companyType' => $companyType, 
    ]);
}

    public function create()
    {
        return view('Superadmin/users/create', [
            'title'     => 'Tambah User',
            'roles'     => $this->roleModel->findAll(),
            'companies' => $this->companyModel->findAll()
        ]);
    }

    public function store()
    {
        $this->userModel->insert([
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id'    => $this->request->getPost('role_id'),
            'company_id' => $this->request->getPost('company_id'),
            'is_active'  => 1
        ]);

        return redirect()->to('/superadmin/users');
    }

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
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
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
        $this->userModel->update($id, [
            'is_active' => $user['is_active'] ? 0 : 1
        ]);

        return redirect()->back();
    }
}