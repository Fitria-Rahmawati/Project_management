<?php
$role = session()->get('role');
$uri = service('uri');
$segment1 = $uri->getSegment(1) ?? 'dashboard';
$segment2 = $uri->getSegment(2) ?? '';

$isReportsActive = ($segment1 == 'admin' && $segment2 == 'reports');
?>

<style>
    /* ========== SIDEBAR STYLES ========== */
    .sidebar {
        background: #ffffff;
        min-height: 100vh;
        color: #5a6e8a;
        border-right: 1px solid #e9ecef;
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.03);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Logo Area */
    .sidebar-logo {
        padding: 24px 20px;
        border-bottom: 1px solid #f0f2f5;
        margin-bottom: 20px;
    }
    .sidebar-logo h4 {
        color: #2c7da0;
        margin: 0;
        font-weight: 700;
        font-size: 1.35rem;
        letter-spacing: -0.3px;
    }
    .sidebar-logo h4 i {
        color: #36b9cc;
    }
    .sidebar-logo small {
        color: #9aa9bc;
        font-size: 11px;
        font-weight: 400;
    }

    /* Navigation Items */
    .sidebar-nav {
        padding: 0 12px;
    }
    .nav-item {
        margin-bottom: 4px;
    }
    .nav-item a {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        border-radius: 10px;
        text-decoration: none;
        color: #5a6e8a;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .nav-item a i {
        width: 32px;
        font-size: 18px;
        color: #9aa9bc;
        transition: all 0.2s;
    }
    .nav-item a:hover {
        background: #f0f7fa;
        color: #2c7da0;
    }
    .nav-item a:hover i {
        color: #36b9cc;
    }
    .nav-item a.active {
        background: linear-gradient(95deg, #e6f4f8 0%, #d9edf3 100%);
        color: #1d6f8f;
    }
    .nav-item a.active i {
        color: #2c7da0;
    }

    /* Section Header */
    .nav-section {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #b0bed0;
        padding: 16px 14px 8px 14px;
        margin-top: 8px;
    }
    .nav-divider {
        height: 1px;
        background: #f0f2f5;
        margin: 12px 14px;
    }

    /* Submenu */
    .has-submenu {
        cursor: pointer;
    }
    .has-submenu .chevron {
        margin-left: auto;
        font-size: 12px;
        color: #cbd5e1;
        transition: transform 0.2s;
    }
    .has-submenu.open .chevron {
        transform: rotate(180deg);
    }
    .submenu {
        display: none;
        padding-left: 0;
        margin-top: 4px;
        margin-bottom: 4px;
    }
    .submenu.show {
        display: block;
    }
    .submenu .nav-subitem a {
        padding: 8px 14px 8px 46px;
        font-size: 13px;
        font-weight: 400;
    }
    .submenu .nav-subitem a i {
        width: 24px;
        font-size: 13px;
    }

    /* Logout */
    .nav-item.logout {
        margin-top: 8px;
    }
    .nav-item.logout a {
        color: #e25c5c;
    }
    .nav-item.logout a i {
        color: #e25c5c;
    }
    .nav-item.logout a:hover {
        background: #fff5f5;
        color: #c0392b;
    }
</style>

<div class="sidebar">
    <div class="sidebar-logo text-center">
        <h4><i class="fas fa-chart-line me-2"></i>PM System</h4>
        <small>PT Vitech Asia</small>
    </div>

    <div class="sidebar-nav">
        <!-- DASHBOARD -->
        <div class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="<?= $segment1 == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- ========== SUPERADMIN ========== -->
        <?php if($role == 'superadmin'): ?>
        <div class="nav-section">Superadmin</div>
        <div class="nav-item">
            <a href="<?= base_url('superadmin/users') ?>" class="<?= ($segment1 == 'superadmin' && $segment2 == 'users') ? 'active' : '' ?>">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('superadmin/roles') ?>" class="<?= ($segment1 == 'superadmin' && $segment2 == 'roles') ? 'active' : '' ?>">
                <i class="fas fa-shield-alt"></i>
                <span>Roles</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('superadmin/companies') ?>" class="<?= ($segment1 == 'superadmin' && $segment2 == 'companies') ? 'active' : '' ?>">
                <i class="fas fa-building"></i>
                <span>Companies</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('superadmin/monitoring') ?>" class="<?= ($segment1 == 'superadmin' && $segment2 == 'monitoring') ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i>
                <span>Monitoring</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- ========== ADMIN ========== -->
        <?php if($role == 'admin'): ?>
        <div class="nav-section">Manajemen</div>
        <div class="nav-item">
            <a href="<?= base_url('admin/projects') ?>" class="<?= ($segment1 == 'admin' && $segment2 == 'projects') ? 'active' : '' ?>">
                <i class="fas fa-project-diagram"></i>
                <span>Projects</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('admin/employees') ?>" class="<?= ($segment1 == 'employees') ? 'active' : '' ?>">
                <i class="fas fa-users"></i>
                <span>Karyawan</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('admin/teams') ?>" class="<?= ($segment1 == 'admin' && $segment2 == 'teams') ? 'active' : '' ?>">
                <i class="fas fa-users-cog"></i>
                <span>Teams</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('admin/issues') ?>" class="<?= ($segment1 == 'admin' && $segment2 == 'issues') ? 'active' : '' ?>">
                <i class="fas fa-exclamation-circle"></i>
                <span>Issues</span>
            </a>
        </div>

        <div class="nav-section">Laporan</div>
        <div class="nav-item has-submenu <?= $isReportsActive ? 'open' : '' ?>" onclick="toggleSubmenu(this)">
            <a href="javascript:void(0)" class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar"></i> Reports</span>
                <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="submenu <?= $isReportsActive ? 'show' : '' ?>">
                <div class="nav-subitem">
                    <a href="<?= base_url('admin/reports/projects') ?>">
                        <i class="fas fa-project-diagram"></i> Laporan Proyek
                    </a>
                </div>
                <div class="nav-subitem">
                    <a href="<?= base_url('admin/reports/issues') ?>">
                        <i class="fas fa-bug"></i> Laporan Issue
                    </a>
                </div>
                <div class="nav-subitem">
                    <a href="<?= base_url('admin/reports/team') ?>">
                        <i class="fas fa-users"></i> Laporan Kinerja Tim
                    </a>
                </div>
                <div class="nav-subitem">
                    <a href="<?= base_url('admin/reports/clients') ?>">
                        <i class="fas fa-building"></i> Laporan Client
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- ========== STAFF ========== -->
        <?php if($role == 'staff'): ?>
        <div class="nav-section">Staff Menu</div>
        <div class="nav-item">
            <a href="<?= base_url('staff/tasks') ?>" class="<?= ($segment1 == 'staff' && $segment2 == 'tasks') ? 'active' : '' ?>">
                <i class="fas fa-tasks"></i>
                <span>My Tasks</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('staff/issues') ?>" class="<?= ($segment1 == 'staff' && $segment2 == 'issues') ? 'active' : '' ?>">
                <i class="fas fa-exclamation-circle"></i>
                <span>My Issues</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('staff/projects') ?>" class="<?= ($segment1 == 'staff' && $segment2 == 'projects') ? 'active' : '' ?>">
                <i class="fas fa-project-diagram"></i>
                <span>My Projects</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- ========== CLIENT ========== -->
        <?php if($role == 'client'): ?>
        <div class="nav-section">Client Menu</div>
        <div class="nav-item">
            <a href="<?= base_url('client/projects') ?>" class="<?= ($segment1 == 'client' && $segment2 == 'projects') ? 'active' : '' ?>">
                <i class="fas fa-eye"></i>
                <span>My Projects</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('client/progress') ?>" class="<?= ($segment1 == 'client' && $segment2 == 'progress') ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i>
                <span>Progress Reports</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= base_url('client/issues') ?>" class="<?= ($segment1 == 'client' && $segment2 == 'issues') ? 'active' : '' ?>">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Kendala</span>
            </a>
        </div>
        <?php endif; ?>

        <div class="nav-divider"></div>
<?php
// Hitung jumlah notifikasi belum dibaca
$unreadNotif = 0;
if (session()->get('logged_in')) {
    $db = \Config\Database::connect();
    $unreadNotif = $db->table('notifications')
        ->where('user_id', session()->get('user_id'))
        ->where('is_read', 0)
        ->countAllResults();
}
?>

<!-- Menu Notifikasi -->
<li class="nav-item">
    <a class="nav-link position-relative" href="<?= base_url('notifications') ?>">
        <i class="fas fa-bell"></i> Notifikasi
        <?php if($unreadNotif > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $unreadNotif > 9 ? '9+' : $unreadNotif ?>
                <span class="visually-hidden">notifikasi baru</span>
            </span>
        <?php endif; ?>
    </a>
</li>
        <!-- ========== AKUN ========== -->
        <div class="nav-section">Akun</div>
        <div class="nav-item">
            <a href="<?= base_url('profile') ?>">
                <i class="fas fa-user-circle"></i>
                <span>Profile</span>
            </a>
        </div>
        <div class="nav-item logout">
            <a href="<?= base_url('logout') ?>">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>

<script>
function toggleSubmenu(element) {
    element.classList.toggle('open');
    const submenu = element.querySelector('.submenu');
    if (submenu) {
        submenu.classList.toggle('show');
    }
}

// Set active state untuk submenu berdasarkan URL
document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;
    const submenuItems = document.querySelectorAll('.submenu a');
    
    submenuItems.forEach(item => {
        if (currentUrl.includes(item.getAttribute('href'))) {
            item.classList.add('active');
            const parentSubmenu = item.closest('.submenu');
            if (parentSubmenu) {
                parentSubmenu.classList.add('show');
                const parentHasSubmenu = parentSubmenu.closest('.has-submenu');
                if (parentHasSubmenu) {
                    parentHasSubmenu.classList.add('open');
                }
            }
        }
    });
});
</script>