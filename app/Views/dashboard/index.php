
<main class="content">

    <?php if ($role === 'superadmin'): ?>
        <?= $this->include('dashboard/superadmin') ?>
    <?php elseif ($role === 'admin'): ?>
        <?= $this->include('dashboard/admin') ?>
    <?php elseif ($role === 'client'): ?>
        <?= $this->include('dashboard/client') ?>
    <?php elseif ($role === 'staff'): ?>
        <?= $this->include('dashboard/staff') ?>
    <?php endif; ?>
</main>

<?= $this->include('layout/footer') ?>