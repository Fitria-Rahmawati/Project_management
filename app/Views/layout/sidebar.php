<?php $role = session('role'); ?>

<aside class="sidebar">
    <h3><?= strtoupper($role) ?></h3>

    <ul>
        <li><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>

        <?php if ($role === 'superadmin'): ?>
            <li><a href="<?= base_url('superadmin/companies') ?>">Data Perusahaan</a></li>
            <li><a href="<?= base_url('superadmin/users') ?>">Data User</a></li>
            <li><a href="<?= base_url('superadmin/roles') ?>">Role & Hak Akses</a></li>
            <li><a href="<?= base_url('superadmin/monitoring') ?>">Monitoring Sistem</a></li>

        <?php elseif ($role === 'admin'): ?>
            <li><a href="<?= base_url('admin/projects') ?>">Data Proyek</a></li>
            <li><a href="<?= base_url('admin/teams') ?>">Tim Proyek</a></li>
            <li><a href="<?= base_url('admin/issues') ?>">Issue Proyek</a></li>
            <li><a href="<?= base_url('admin/reports') ?>">Laporan</a></li>

        <?php elseif ($role === 'client'): ?>
            <li><a href="<?= base_url('client/projects') ?>">Proyek Saya</a></li>
            <li><a href="<?= base_url('client/progress') ?>">Progres Proyek</a></li>
            <li><a href="<?= base_url('client/issues') ?>">Laporan Issue</a></li>

        <?php elseif ($role === 'staff'): ?>
            <li><a href="<?= base_url('staff/tasks') ?>">Tugas Saya</a></li>
            <li><a href="<?= base_url('staff/progress') ?>">Update Progres</a></li>
            <li><a href="<?= base_url('staff/issues') ?>">Issue Tugas</a></li>
        <?php endif; ?>

        <li class="divider"></li>

        <li><a class="logout" href="<?= base_url('logout') ?>">Logout</a></li>
    </ul>
</aside>