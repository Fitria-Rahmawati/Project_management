<?php

namespace App\Controllers;

use App\Models\CompanyModel;

class CompanyController extends BaseController
{
    protected $companyModel;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
    }

    // ================= INDEX =================
    public function index()
    {
    $search = $this->request->getGet('search');
    $status = $this->request->getGet('status');

    $builder = $this->companyModel;

    if ($search) {
        $builder = $builder->like('company_name', $search);
    }

    if ($status !== null && $status !== '') {
        $builder = $builder->where('is_active', $status);
    }
        return view('company/index', [
            'companies' => $builder->findAll()
        ]);
    }
public function toggleStatus($id)
{
    $company = $this->companyModel->find($id);

    $newStatus = $company['is_active'] == 1 ? 0 : 1;

    $this->companyModel->update($id, [
        'is_active' => $newStatus
    ]);

    return redirect()->to('/superadmin/companies');
}
    // ================= CREATE =================
    public function create()
    {
        return view('company/create');
    }

    // ================= STORE =================
    public function store()
    {
        $data = [
            'company_name'   => $this->request->getPost('company_name'),
            'company_type'   => $this->request->getPost('company_type'),
            'contact_person' => $this->request->getPost('contact_person'),
            'email'          => $this->request->getPost('email'),
            'phone'          => $this->request->getPost('phone'),
            'is_active'      => 1,
        ];

        $this->companyModel->insert($data);

        return redirect()->to('/superadmin/companies');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        return view('company/edit', [
            'company' => $this->companyModel->find($id)
        ]);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $data = [
            'company_name'   => $this->request->getPost('company_name'),
            'company_type'   => $this->request->getPost('company_type'),
            'contact_person' => $this->request->getPost('contact_person'),
            'email'          => $this->request->getPost('email'),
            'phone'          => $this->request->getPost('phone'),
            'is_active'      => $this->request->getPost('is_active'),
        ];

        $this->companyModel->update($id, $data);

        return redirect()->to('/superadmin/companies');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->companyModel->delete($id);

        return redirect()->to('/superadmin/companies');
    }
}