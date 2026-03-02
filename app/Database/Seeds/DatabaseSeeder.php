<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ======================
        // MASTER RBAC
        // ======================
        $this->call('RoleSeeder');
        $this->call('PermissionSeeder');
        $this->call('RolePermissionSeeder');

        // ======================
        // MASTER DATA
        // ======================
        $this->call('CompanieSeeder');
        $this->call('PositionSeeder');
        $this->call('DepartementSeeder');

        // ======================
        // USER & EMPLOYEE
        // ======================
        $this->call('UserSeeder');
        $this->call('EmployeeSeeder');

        // ======================
        // PROJECT
        // ======================
        $this->call('ProjectSeeder');
        $this->call('ProjectMemberSeeder');
        $this->call('IssueSeeder');
        $this->call('IssueLogSeeder');
    }
}