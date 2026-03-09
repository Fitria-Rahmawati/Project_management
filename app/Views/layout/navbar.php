<?php
$role = session()->get('role');
$fullName = session()->get('full_name') ?? session()->get('username');
$initial = strtoupper(substr($fullName, 0, 1));
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-tasks me-2"></i>
            Project System
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" 
                       href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <?php if(in_array($role, ['superadmin', 'admin'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog me-1"></i> Manajemen
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($role == 'superadmin'): ?>
                            <li><a class="dropdown-item" href="<?= base_url('superadmin/users') ?>">
                                <i class="fas fa-users me-2"></i>Users
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('superadmin/roles') ?>">
                                <i class="fas fa-shield-alt me-2"></i>Roles
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= base_url('admin/projects') ?>">
                            <i class="fas fa-project-diagram me-2"></i>Projects
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/teams') ?>">
                            <i class="fas fa-users-cog me-2"></i>Teams
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/issues') ?>">
                            <i class="fas fa-exclamation-circle me-2"></i>Issues
                        </a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if($role == 'staff'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'staff/my-tasks' ? 'active' : '' ?>" 
                       href="<?= base_url('staff/my-tasks') ?>">
                        <i class="fas fa-tasks me-1"></i> My Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'staff/my-projects' ? 'active' : '' ?>" 
                       href="<?= base_url('staff/my-projects') ?>">
                        <i class="fas fa-project-diagram me-1"></i> My Projects
                    </a>
                </li>
                <?php endif; ?>
                <?php if($role == 'client'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'client/my-projects' ? 'active' : '' ?>" 
                       href="<?= base_url('client/my-projects') ?>">
                        <i class="fas fa-eye me-1"></i> My Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'client/reports' ? 'active' : '' ?>" 
                       href="<?= base_url('client/reports') ?>">
                        <i class="fas fa-chart-bar me-1"></i> Reports
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown me-2">
                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#">Task assigned to you</a></li>
                        <li><a class="dropdown-item" href="#">Project update</a></li>
                        <li><a class="dropdown-item" href="#">New issue reported</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#">View all</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center me-2" 
                             style="width: 32px; height: 32px; font-weight: bold;">
                            <?= $initial ?>
                        </div>
                        <div>
                            <div style="font-size: 12px; line-height: 1.2;"><?= $fullName ?></div>
                            <div style="font-size: 10px; opacity: 0.8;"><?= ucfirst($role) ?></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('profile') ?>">
                            <i class="fas fa-user-circle me-2"></i>Profile
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('profile/change-password') ?>">
                            <i class="fas fa-key me-2"></i>Change Password
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>