<main class="content">
    <h2>Welcome, <?= $username ?> (STAFF)</h2>

    <div class="dashboard-cards" style="display:flex; gap:20px; flex-wrap:wrap;">
        <div class="card">My Tasks: <?= $myTasks ?></div>
        <div class="card">My Projects: <?= $myProjects ?></div>
        <div class="card">Pending Issues: <?= $pendingIssues ?></div>
    </div>

    <div class="shortcut-buttons" style="margin-top:20px;">
        <a href="<?= base_url('staff/tasks') ?>">Tasks</a>
        <a href="<?= base_url('staff/progress') ?>">Progress</a>
        <a href="<?= base_url('staff/issues') ?>">Issues</a>
    </div>
</main>