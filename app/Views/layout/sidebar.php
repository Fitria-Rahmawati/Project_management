<?php $role = session('role'); ?>

<aside class="sidebar">

    <div class="sidebar-header">
        <h4><?= strtoupper($role) ?> PANEL</h4>
    </div>

    <ul class="sidebar-menu">

        <!-- DASHBOARD -->
        <li>
            <a href="<?= base_url('dashboard') ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>

        <?php if ($role === 'superadmin'): ?>

            <li class="menu-title">Master Data</li>

            <li>
                <a href="<?= base_url('superadmin/companies') ?>">
                    <i class="fas fa-building"></i> Data Perusahaan
                </a>
            </li>

            <li>
                <a href="<?= base_url('superadmin/users') ?>">
                    <i class="fas fa-users"></i> Data User
                </a>
            </li>

            <li>
                <a href="<?= base_url('superadmin/roles') ?>">
                    <i class="fas fa-user-shield"></i> Role & Hak Akses
                </a>
            </li>

            <li class="menu-title">Monitoring</li>

            <li>
                <a href="<?= base_url('superadmin/monitoring') ?>">
                    <i class="fas fa-chart-line"></i> Monitoring Sistem
                </a>
            </li>

            <li>
                <a href="<?= base_url('superadmin/reports') ?>">
                    <i class="fas fa-file-alt"></i> Laporan Sistem
                </a>
            </li>


        <?php elseif ($role === 'admin'): ?>

            <li class="menu-title">Project Management</li>

            <li>
                <a href="<?= base_url('admin/projects') ?>">
                    <i class="fas fa-folder"></i> Data Proyek
                </a>
            </li>

            <li>
                <a href="<?= base_url('admin/teams') ?>">
                    <i class="fas fa-users-cog"></i> Tim Proyek
                </a>
            </li>

            <li>
                <a href="<?= base_url('admin/issues') ?>">
                    <i class="fas fa-exclamation-circle"></i> Issue Proyek
                </a>
            </li>

            <li>
                <a href="<?= base_url('admin/reports') ?>">
                    <i class="fas fa-file"></i> Laporan Proyek
                </a>
            </li>


        <?php elseif ($role === 'client'): ?>

            <li class="menu-title">Project Client</li>

            <li>
                <a href="<?= base_url('client/projects') ?>">
                    <i class="fas fa-folder-open"></i> Proyek Saya
                </a>
            </li>

            <li>
                <a href="<?= base_url('client/progress') ?>">
                    <i class="fas fa-chart-bar"></i> Progres Proyek
                </a>
            </li>

            <li>
                <a href="<?= base_url('client/issues') ?>">
                    <i class="fas fa-bug"></i> Laporan Issue
                </a>
            </li>


        <?php elseif ($role === 'staff'): ?>

            <li class="menu-title">Task Management</li>

            <li>
                <a href="<?= base_url('staff/tasks') ?>">
                    <i class="fas fa-tasks"></i> Tugas Saya
                </a>
            </li>

            <li>
                <a href="<?= base_url('staff/progress') ?>">
                    <i class="fas fa-sync"></i> Update Progres
                </a>
            </li>

            <li>
                <a href="<?= base_url('staff/issues') ?>">
                    <i class="fas fa-bug"></i> Issue Tugas
                </a>
            </li>

        <?php endif; ?>


        <li class="divider"></li>

        <li>
            <a class="logout" href="<?= base_url('logout') ?>">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>

    </ul>

</aside>