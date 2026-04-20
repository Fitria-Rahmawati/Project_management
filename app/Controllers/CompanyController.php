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
        
        return view('Superadmin/company/index', [  
            'title' => 'Data Perusahaan',
            'companies' => $builder->findAll()
        ]);
    }

    // ================= TOGGLE STATUS =================
    public function toggleStatus($id)
    {
        $company = $this->companyModel->find($id);
        $newStatus = $company['is_active'] == 1 ? 0 : 1;

        $this->companyModel->update($id, [
            'is_active' => $newStatus
        ]);

        return redirect()->to('/superadmin/companies')->with('success', 'Status berhasil diubah');
    }

    // ================= CREATE =================
    public function create()
    {
        return view('Superadmin/company/create', [  
            'title' => 'Tambah Perusahaan'
        ]);
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
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $this->companyModel->insert($data);

        return redirect()->to('/superadmin/companies')->with('success', 'Perusahaan berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $company = $this->companyModel->find($id);
        
        if (!$company) {
            return redirect()->to('/superadmin/companies')->with('error', 'Data tidak ditemukan');
        }
        
        return view('superadmin/company/edit', [
            'title' => 'Edit Perusahaan',
            'company' => $company
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
            'contract_start' => $this->request->getPost('contract_start') ?: null,   
            'contract_end'   => $this->request->getPost('contract_end') ?: null,     
            'contract_status'=> $this->request->getPost('contract_status'),         
            'is_active'      => $this->request->getPost('is_active'),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $this->companyModel->update($id, $data);

        return redirect()->to('/superadmin/companies')->with('success', 'Perusahaan berhasil diupdate');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $projectCount = $db->table('projects')->where('company_id', $id)->countAllResults();
        
        if ($projectCount > 0) {
            return redirect()->to('/superadmin/companies')
                ->with('error', 'Tidak dapat menghapus perusahaan yang memiliki proyek');
        }
        
        $this->companyModel->delete($id);

        return redirect()->to('/superadmin/companies')->with('success', 'Perusahaan berhasil dihapus');
    }
    // ================= DETAIL / SHOW =================
    public function show($id)
    {
        $company = $this->companyModel->find($id);
        
        if (!$company) {
            return redirect()->to('/superadmin/companies')->with('error', 'Data tidak ditemukan');
        }
        
        return view('Superadmin/company/show', [
            'title' => 'Detail Perusahaan',
            'company' => $company
        ]);
    }
}