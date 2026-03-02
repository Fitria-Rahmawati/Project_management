<main class="content">
    <h2>Welcome, <?= $username ?> (ADMIN)</h2>

    <div class="dashboard-cards" style="display:flex; gap:20px; flex-wrap:wrap;">
        <div class="card">Total Projects: <?= $totalProjects ?></div>
        <div class="card">Total Employees: <?= $totalEmployees ?></div>
        <div class="card">Active Employees: <?= $activeEmployees ?></div>
        <div class="card">Projects In Progress: <?= $inProgressProjects ?></div>
    </div>

    <div class="shortcut-buttons" style="margin-top:20px;">
        <a href="<?= base_url('admin/projects') ?>">Projects</a>
        <a href="<?= base_url('admin/teams') ?>">Teams</a>
        <a href="<?= base_url('admin/issues') ?>">Issues</a>
        <a href="<?= base_url('admin/reports') ?>">Reports</a>
    </div>
</main>