<?php
$role = session()->get('role');
$fullName = session()->get('full_name') ?? session()->get('username');
$initial = strtoupper(substr($fullName, 0, 1));

// Hitung notifikasi belum dibaca
$unreadNotif = 0;
if (session()->get('isLoggedIn')) {
    $db = \Config\Database::connect();
    if ($db->tableExists('notifications')) {
        $unreadNotif = $db->table('notifications')
            ->where('user_id', session()->get('user_id'))
            ->where('is_read', 0)
            ->countAllResults();
    }
}
?>

<style>
    /* ==================== NAVBAR STYLES ==================== */
    .navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        padding: 0.75rem 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .navbar-brand {
        font-weight: 700;
        font-size: 1.35rem;
        letter-spacing: -0.5px;
        color: white !important;
    }
    .navbar-brand i {
        font-size: 1.4rem;
    }
    .nav-link {
        font-weight: 500;
        padding: 0.6rem 1rem !important;
        border-radius: 10px;
        transition: all 0.3s;
        margin: 0 2px;
        color: rgba(255,255,255,0.9) !important;
    }
    .nav-link:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-1px);
        color: white !important;
    }
    .nav-link.active {
        background: rgba(255,255,255,0.25);
        color: white !important;
    }
    .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        margin-top: 8px;
        padding: 8px 0;
        animation: fadeInDown 0.2s ease;
    }
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .dropdown-item {
        padding: 8px 20px;
        font-size: 13px;
        transition: all 0.2s;
    }
    .dropdown-item:hover {
        background: linear-gradient(135deg, #667eea10, #764ba210);
        padding-left: 24px;
    }
    .dropdown-item i {
        width: 20px;
        color: #667eea;
    }
    .dropdown-header {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #858796;
        padding: 12px 20px 6px;
    }
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -8px;
        background: #e74a3b;
        border: 2px solid #667eea;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 20px;
        min-width: 18px;
    }
    .user-avatar {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.25);
        color: white;
        font-weight: 700;
        font-size: 14px;
    }
    .user-info {
        line-height: 1.3;
    }
    .user-name {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 2px;
        color: white;
    }
    .user-role {
        font-size: 10px;
        opacity: 0.8;
        color: rgba(255,255,255,0.8);
    }
    .notif-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s;
    }
    .notif-item:hover {
        background: #f8f9fc;
    }
    .notif-item.unread {
        background: linear-gradient(135deg, #667eea08, #764ba208);
    }
    .notif-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .notif-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 2px;
    }
    .notif-time {
        font-size: 10px;
        color: #999;
    }
    .btn-view-all {
        color: #667eea;
        font-weight: 600;
        padding: 10px;
    }
    .btn-view-all:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    .navbar-toggler {
        border-color: rgba(255,255,255,0.5);
    }
    .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }
    @media (max-width: 992px) {
        .navbar {
            padding: 0.5rem 1rem;
        }
        .nav-link {
            padding: 0.5rem 0.8rem !important;
        }
        .user-info {
            display: none;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <!-- Brand Logo -->
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-chart-line me-2"></i>
            <span>ProjectSystem</span>
        </a>
        
        <!-- Toggler Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Left Menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" 
                       href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </li>
                
                <!-- Manajemen Menu (Admin & Superadmin) -->
                <?php if(in_array($role, ['superadmin', 'admin'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog me-1"></i> Manajemen
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($role == 'superadmin'): ?>
                            <li><a class="dropdown-item" href="<?= base_url('superadmin/users') ?>">
                                <i class="fas fa-users me-2"></i> Users
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('superadmin/roles') ?>">
                                <i class="fas fa-shield-alt me-2"></i> Roles
                            </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('superadmin/companies') ?>">
                                <i class="fas fa-building me-2"></i> Companies
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= base_url('admin/projects') ?>">
                            <i class="fas fa-project-diagram me-2"></i> Projects
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/teams') ?>">
                            <i class="fas fa-users-cog me-2"></i> Teams
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/issues') ?>">
                            <i class="fas fa-exclamation-circle me-2"></i> Issues
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/reports') ?>">
                            <i class="fas fa-chart-line me-2"></i> Reports
                        </a></li>
                    </ul>
                </li>
                <?php endif; ?>
                
                <!-- Staff Menu -->
                <?php if($role == 'staff'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'staff/tasks' ? 'active' : '' ?>" 
                       href="<?= base_url('staff/tasks') ?>">
                        <i class="fas fa-tasks me-1"></i> My Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'staff/projects' ? 'active' : '' ?>" 
                       href="<?= base_url('staff/projects') ?>">
                        <i class="fas fa-project-diagram me-1"></i> My Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'staff/issues' ? 'active' : '' ?>" 
                       href="<?= base_url('staff/issues') ?>">
                        <i class="fas fa-exclamation-triangle me-1"></i> My Issues
                    </a>
                </li>
                <?php endif; ?>
                
                <!-- Client Menu -->
                <?php if($role == 'client'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'client/projects' ? 'active' : '' ?>" 
                       href="<?= base_url('client/projects') ?>">
                        <i class="fas fa-eye me-1"></i> My Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'client/progress' ? 'active' : '' ?>" 
                       href="<?= base_url('client/progress') ?>">
                        <i class="fas fa-chart-line me-1"></i> Progress
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'client/issues' ? 'active' : '' ?>" 
                       href="<?= base_url('client/issues') ?>">
                        <i class="fas fa-exclamation-triangle me-1"></i> Kendala
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            
            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto">
                <!-- Notifikasi Dropdown -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell fa-lg"></i>
                        <?php if($unreadNotif > 0): ?>
                            <span class="notification-badge"><?= $unreadNotif > 9 ? '9+' : $unreadNotif ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="width: 350px;">
                        <li><h6 class="dropdown-header">
                            <i class="fas fa-bell me-2"></i> Notifikasi 
                            <?php if($unreadNotif > 0): ?>
                                <span class="badge bg-danger ms-2"><?= $unreadNotif ?> baru</span>
                            <?php endif; ?>
                        </h6></li>
                        <li><hr class="dropdown-divider"></li>
                        
                        <?php if($unreadNotif > 0): ?>
                        <!-- Preview beberapa notifikasi -->
                        <li class="notif-item unread">
                            <div class="d-flex gap-2">
                                <div class="notif-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="notif-title">Task Baru Ditugaskan</div>
                                    <div class="notif-time">5 menit yang lalu</div>
                                </div>
                            </div>
                        </li>
                        <?php else: ?>
                        <li class="text-center py-4 text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-2"></i>
                            <p class="mb-0 small">Tidak ada notifikasi baru</p>
                        </li>
                        <?php endif; ?>
                        
                        <li><hr class="dropdown-divider"></li>
                        <li class="text-center">
                            <a href="<?= base_url('notifications') ?>" class="dropdown-item btn-view-all">
                                Lihat Semua Notifikasi <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle user-avatar d-flex align-items-center justify-content-center me-2">
                            <?= $initial ?>
                        </div>
                        <div class="user-info">
                            <div class="user-name"><?= $fullName ?></div>
                            <div class="user-role"><?= ucfirst($role) ?></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('profile') ?>">
                            <i class="fas fa-user-circle me-2"></i> Profile
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('profile/change-password') ?>">
                            <i class="fas fa-key me-2"></i> Change Password
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('notifications') ?>">
                            <i class="fas fa-bell me-2"></i> Notifikasi
                            <?php if($unreadNotif > 0): ?>
                                <span class="badge bg-danger ms-2"><?= $unreadNotif ?></span>
                            <?php endif; ?>
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>