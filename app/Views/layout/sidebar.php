<?php
$role = session()->get('role');
$uri = service('uri');
$segment1 = $uri->getSegment(1) ?? 'dashboard';
$segment2 = $uri->getSegment(2) ?? '';

$isReportsActive = ($segment1 == 'admin' && $segment2 == 'reports');
?>

<div class="bg-light vh-100 border-end p-0">
    <div class="list-group list-group-flush rounded-0">
       
        <a href="<?= base_url('dashboard') ?>" 
           class="list-group-item list-group-item-action border-0 <?= $segment1 == 'dashboard' ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>

   
        <?php if($role == 'superadmin'): ?>
        <div class="list-group-item bg-light fw-bold">Superadmin</div>
        <a href="<?= base_url('superadmin/users') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'superadmin' && $segment2 == 'users') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-users me-2"></i> Users
        </a>
        <a href="<?= base_url('superadmin/roles') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'superadmin' && $segment2 == 'roles') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-shield-alt me-2"></i> Roles
        </a>
        <a href="<?= base_url('superadmin/companies') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'superadmin' && $segment2 == 'companies') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-building me-2"></i> Companies
        </a>
            <a href="<?= base_url('superadmin/monitoring') ?>" 
            class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'superadmin' && $segment2 == 'monitoring') ? 'active bg-primary text-white' : '' ?>">
                <i class="fas fa-chart-line me-2"></i> Monitoring
            </a>
        <?php endif; ?>

    
        <?php if(in_array($role, ['admin'])): ?>
        <div class="list-group-item bg-light fw-bold mt-2">Manajemen</div>
        <a href="<?= base_url('admin/projects') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'admin' && $segment2 == 'projects') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-project-diagram me-2"></i> Projects
        </a>
        <a href="<?= base_url('admin/teams') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'admin' && $segment2 == 'teams') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-users-cog me-2"></i> Teams
        </a>
        <a href="<?= base_url('admin/issues') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'admin' && $segment2 == 'issues') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-exclamation-circle me-2"></i> Issues
        </a>

       
        <div class="list-group-item list-group-item-action border-0 ps-4 d-flex justify-content-between align-items-center" 
             style="cursor: pointer;" 
             onclick="toggleReports()">
            <div>
                <i class="fas fa-chart-bar me-2"></i> Reports
            </div>
            <i class="fas fa-chevron-<?= $isReportsActive ? 'up' : 'down' ?>" id="reportsArrow" style="font-size: 12px;"></i>
        </div>

        <div id="reportsSubmenu" style="display: <?= $isReportsActive ? 'block' : 'none' ?>;">
            <a href="<?= base_url('admin/reports/projects') ?>" 
               class="list-group-item list-group-item-action border-0 ps-5 py-2 <?= ($segment2 == 'reports' && strpos(uri_string(), 'projects') !== false) ? 'active bg-primary text-white' : '' ?>">
                <i class="fas fa-project-diagram me-2"></i> Laporan Progress Proyek
            </a>
            <a href="<?= base_url('admin/reports/issues') ?>" 
               class="list-group-item list-group-item-action border-0 ps-5 py-2 <?= ($segment2 == 'reports' && strpos(uri_string(), 'issues') !== false) ? 'active bg-primary text-white' : '' ?>">
                <i class="fas fa-bug me-2"></i> Laporan Issue
            </a>
            <a href="<?= base_url('admin/reports/team') ?>" 
               class="list-group-item list-group-item-action border-0 ps-5 py-2 <?= ($segment2 == 'reports' && strpos(uri_string(), 'team') !== false) ? 'active bg-primary text-white' : '' ?>">
                <i class="fas fa-users me-2"></i> Laporan Kinerja Tim
            </a>
            <a href="<?= base_url('admin/reports/clients') ?>" 
               class="list-group-item list-group-item-action border-0 ps-5 py-2 <?= ($segment2 == 'reports' && strpos(uri_string(), 'clients') !== false) ? 'active bg-primary text-white' : '' ?>">
                <i class="fas fa-building me-2"></i> Laporan Client
            </a>
        </div>
        <?php endif; ?>

    
        <?php if($role == 'staff'): ?>
        <div class="list-group-item bg-light fw-bold mt-2">Staff</div>
        <a href="<?= base_url('staff/my-tasks') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'staff' && $segment2 == 'my-tasks') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-tasks me-2"></i> My Tasks
        </a>
        <a href="<?= base_url('staff/my-projects') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'staff' && $segment2 == 'my-projects') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-project-diagram me-2"></i> My Projects
        </a>
        <?php endif; ?>

        <?php if($role == 'client'): ?>
        <div class="list-group-item bg-light fw-bold mt-2">Client</div>
        <a href="<?= base_url('client/my-projects') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'client' && $segment2 == 'my-projects') ? 'active bg-primary text-white' : '' ?>">
            <i class="fas fa-eye me-2"></i> My Projects
        </a>
        <a href="<?= base_url('client/reports') ?>" 
           class="list-group-item list-group-item-action border-0 ps-4 <?= ($segment1 == 'client' && $segment2 == 'reports') ? 'active bg-primary text-white' : '' ?>">
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

<script>
function toggleReports() {
    const submenu = document.getElementById('reportsSubmenu');
    const arrow = document.getElementById('reportsArrow');
    
    if (submenu.style.display === 'none') {
        submenu.style.display = 'block';
        arrow.classList.remove('fa-chevron-down');
        arrow.classList.add('fa-chevron-up');
    } else {
        submenu.style.display = 'none';
        arrow.classList.remove('fa-chevron-up');
        arrow.classList.add('fa-chevron-down');
    }
}
</script>