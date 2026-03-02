<main class="content">
    <h2>Welcome, <?= $username ?> (CLIENT)</h2>

    <div class="dashboard-cards" style="display:flex; gap:20px; flex-wrap:wrap;">
        <div class="card">My Projects: <?= $myProjects ?></div>
        <div class="card">Ongoing Projects: <?= $ongoingProjects ?></div>
    </div>

    <div class="shortcut-buttons" style="margin-top:20px;">
        <a href="<?= base_url('client/projects') ?>">My Projects</a>
        <a href="<?= base_url('client/progress') ?>">Progress</a>
        <a href="<?= base_url('client/issues') ?>">Issues</a>
    </div>
</main>