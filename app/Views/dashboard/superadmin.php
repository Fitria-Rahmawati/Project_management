<main class="content" style="padding:20px; font-family:sans-serif;">

    <!-- Welcome -->
    <h2>Welcome, <?= $username ?> (<?= strtoupper($role) ?>)</h2>

    <!-- Statistic Cards -->
    <div class="dashboard-cards" style="display:flex; flex-wrap:wrap; gap:20px; margin-top:20px;">
        <div class="card" style="flex:1 1 200px; background:#4e73df; color:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
            <h4>Total Companies</h4>
            <p style="font-size:28px; font-weight:bold;"><?= $totalCompanies ?></p>
        </div>

        <div class="card" style="flex:1 1 200px; background:#1cc88a; color:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
            <h4>Total Users</h4>
            <p style="font-size:28px; font-weight:bold;"><?= $totalUsers ?></p>
        </div>

        <div class="card" style="flex:1 1 200px; background:#f6c23e; color:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
            <h4>Active Users</h4>
            <p style="font-size:28px; font-weight:bold;"><?= $activeUsers ?></p>
        </div>
    </div>

    <!-- Quick Access -->
    <h3 style="margin-top:40px;">Quick Access</h3>
    <div class="shortcut-buttons" style="display:flex; flex-wrap:wrap; gap:15px; margin-top:10px;">
        <a href="<?= base_url('superadmin/companies') ?>" style="background:#4e73df; color:white; padding:15px 25px; border-radius:6px; text-decoration:none; font-weight:bold;">Companies</a>
        <a href="<?= base_url('superadmin/users') ?>" style="background:#1cc88a; color:white; padding:15px 25px; border-radius:6px; text-decoration:none; font-weight:bold;">Users</a>
        <a href="<?= base_url('superadmin/roles') ?>" style="background:#f6c23e; color:white; padding:15px 25px; border-radius:6px; text-decoration:none; font-weight:bold;">Roles</a>
        <a href="<?= base_url('superadmin/projects') ?>" style="background:#36b9cc; color:white; padding:15px 25px; border-radius:6px; text-decoration:none; font-weight:bold;">Projects</a>
    </div>

</main>