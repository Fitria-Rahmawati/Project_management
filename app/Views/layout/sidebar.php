<?php
$role = session()->get('role');
$uri = service('uri');
$segment = $uri->getSegment(1) ?? 'dashboard';
?>
<div class="bg-light vh-100 border-end p-0">
    <div class="list-group list-group-flush rounded-0">
        <a href="<?= base_url('dashboard') ?>" 
           class="list-group-item list-group-item-action border-0 <?= $segment == 'dashboard' ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <?php if($role == 'superadmin'): ?>
        <div class="list-group-item bg-light fw-bold">Superadmin</div>
        <a href="<?= base_url('superadmin/users') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'superadmin' && uri_string() == 'superadmin/users' ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-users me-2"></i> Users
        </a>
        <a href="<?= base_url('superadmin/roles') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'superadmin' && uri_string() == 'superadmin/roles' ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-shield-alt me-2"></i> Roles
        </a>
        <a href="<?= base_url('superadmin/companies') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'superadmin' && uri_string() == 'superadmin/companies' ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-building me-2"></i> Companies
        </a>
        <?php endif; ?>
        <?php if(in_array($role, ['superadmin', 'admin'])): ?>
        <div class="list-group-item bg-light fw-bold mt-2">Manajemen</div>
        <a href="<?= base_url('admin/projects') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'admin' && strpos(uri_string(), 'projects') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-project-diagram me-2"></i> Projects
        </a>
        <a href="<?= base_url('admin/teams') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'admin' && strpos(uri_string(), 'teams') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-users-cog me-2"></i> Teams
        </a>
        <a href="<?= base_url('admin/issues') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'admin' && strpos(uri_string(), 'issues') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-exclamation-circle me-2"></i> Issues
        </a>
        <a href="<?= base_url('admin/reports') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'admin' && strpos(uri_string(), 'reports') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-chart-bar me-2"></i> Reports
        </a>
        <?php endif; ?>
        <?php if($role == 'staff'): ?>
        <div class="list-group-item bg-light fw-bold mt-2">Staff</div>
        <a href="<?= base_url('staff/my-tasks') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'staff' && strpos(uri_string(), 'tasks') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-tasks me-2"></i> My Tasks
        </a>
        <a href="<?= base_url('staff/my-projects') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'staff' && strpos(uri_string(), 'projects') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-project-diagram me-2"></i> My Projects
        </a>
        <?php endif; ?>
        <?php if($role == 'client'): ?>
        <div class="list-group-item bg-light fw-bold mt-2">Client</div>
        <a href="<?= base_url('client/my-projects') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'client' && strpos(uri_string(), 'projects') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-eye me-2"></i> My Projects
        </a>
        <a href="<?= base_url('client/reports') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= $segment == 'client' && strpos(uri_string(), 'reports') !== false ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-chart-bar me-2"></i> Progress Reports
        </a>
        <?php endif; ?>

        <div class="list-group-item bg-light fw-bold mt-2">Akun</div>
        <a href="<?= base_url('profile') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4">
            <i class="fas fa-user-circle me-2"></i> Profile
        </a>
        <a href="<?= base_url('logout') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 text-danger">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>