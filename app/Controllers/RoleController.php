<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $rolePermissionModel;

    public function __construct()
    {
        $this->roleModel           = new RoleModel();
        $this->permissionModel     = new PermissionModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    /**
     * =========================
     * LIST ROLE & PERMISSION
     * =========================
     */
    public function index()
    {
        $roles = $this->roleModel->findAll();

        foreach ($roles as &$role) {
            $role['permissions'] = $this->rolePermissionModel
                ->getPermissionsByRole($role['id']);
        }

        return view('superadmin/roles/index', [
            'title' => 'Manajemen Role',
            'roles' => $roles
        ]);
    }

    /**
     * =========================
     * FORM EDIT ROLE PERMISSION
     * =========================
     */
    public function edit($id)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return redirect()->to('/superadmin/roles');
        }

        return view('superadmin/roles/edit', [
            'title' => 'Edit Hak Akses',
            'role'            => $this->roleModel->find($id),
            'permissions'     => $this->permissionModel->getGroupedBySlug(),
            'rolePermissions' => $this->rolePermissionModel->getPermissionIdsByRole($id)
            ]);
    }

    /**
     * =========================
     * UPDATE ROLE PERMISSION
     * =========================
     */
    public function update($id)
    {
        $permissions = $this->request->getPost('permissions') ?? [];

        // hapus permission lama
        $this->rolePermissionModel->where('role_id', $id)->delete();

        // simpan permission baru
        foreach ($permissions as $permissionId) {
            $this->rolePermissionModel->insert([
                'role_id'       => $id,
                'permission_id' => $permissionId
            ]);
        }

        return redirect()->to('/superadmin/roles')
            ->with('success', 'Hak akses berhasil diperbarui');
    }
}