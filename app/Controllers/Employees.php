<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PositionModel;
use App\Models\DepartementModel;

class Employees extends BaseController
{
    protected $employee;
    protected $position;
    protected $department;

    public function __construct()
    {
        $this->employee   = new EmployeeModel();
        $this->position   = new PositionModel();
        $this->department = new DepartementModel();
    }

    // 🔹 List data employee
    public function index()
    {
        $data['employees'] = $this->employee
            ->select('employees.*, positions.position_name, departements.departement_name')
            ->join('positions', 'positions.id = employees.position_id')
            ->join('departements', 'departements.id = employees.departement_id')
            ->findAll();

        return view('employees/index', $data);
    }

    // 🔹 Form tambah employee
    public function create()
    {
        return view('employees/create', [
            'positions'   => $this->position->findAll(),
            'departments' => $this->department->findAll()
        ]);
    }

    // 🔹 Simpan employee
    public function store()
    {
        $this->employee->save([
            'first_name'      => $this->request->getPost('first_name'),
            'last_name'       => $this->request->getPost('last_name'),
            'email'           => $this->request->getPost('email'),
            'phone'           => $this->request->getPost('phone'),
            'position_id'     => $this->request->getPost('position_id'),
            'departement_id'  => $this->request->getPost('departement_id'),
            'hire_date'       => $this->request->getPost('hire_date'),
            'status'          => $this->request->getPost('status')
        ]);

        return redirect()->to('/employees');
    }

    // 🔹 Form edit employee
    public function edit($id)
    {
        return view('employees/edit', [
            'employee'    => $this->employee->find($id),
            'positions'   => $this->position->findAll(),
            'departments' => $this->department->findAll()
        ]);
    }

    // 🔹 Update employee
    public function update($id)
    {
        $this->employee->update($id, $this->request->getPost());
        return redirect()->to('/employees');
    }

    // 🔹 Hapus employee
    public function delete($id)
    {
        $this->employee->delete($id);
        return redirect()->to('/employees');
    }
}