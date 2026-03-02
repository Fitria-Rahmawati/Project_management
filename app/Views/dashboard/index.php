<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

    <?php if ($role === 'superadmin'): ?>
        <?= $this->include('dashboard/superadmin') ?>
    <?php elseif ($role === 'admin'): ?>
        <?= $this->include('dashboard/admin') ?>
    <?php elseif ($role === 'staff'): ?>
        <?= $this->include('dashboard/staff') ?>
    <?php elseif ($role === 'client'): ?>
        <?= $this->include('dashboard/client') ?>
    <?php endif; ?>

<?= $this->endSection() ?>