<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Progress Report</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #36b9cc; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #36b9cc; margin: 0; font-size: 18px; }
        .header p { margin: 5px 0 0; color: #666; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; gap: 10px; }
        .stat-box { background: #f8f9fa; padding: 10px; text-align: center; width: 23%; border-radius: 5px; }
        .stat-box h3 { margin: 0; color: #36b9cc; font-size: 16px; }
        .stat-box small { font-size: 9px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #36b9cc; color: white; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PROGRESS PROYEK</h1>
        <p><?= $companyName ?> | Periode: <?= date('F Y') ?></p>
        <p>Dicetak: <?= date('d/m/Y H:i:s') ?> | Oleh: <?= session()->get('username') ?></p>
    </div>

    <?php 
    $totalProjects = count($projects);
    $avgProgress = $totalProjects > 0 ? round(array_sum(array_column($projects, 'progress')) / $totalProjects, 2) : 0;
    $totalIssues = array_sum(array_column($projects, 'total_issues'));
    $completedIssues = array_sum(array_column($projects, 'completed_issues'));
    $completionRate = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;
    ?>

    <div class="stats">
        <div class="stat-box"><h3><?= $totalProjects ?></h3><small>Total Proyek</small></div>
        <div class="stat-box"><h3><?= $avgProgress ?>%</h3><small>Rata-rata Progress</small></div>
        <div class="stat-box"><h3><?= $totalIssues ?></h3><small>Total Kendala</small></div>
        <div class="stat-box"><h3><?= $completionRate ?>%</h3><small>Tingkat Penyelesaian</small></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Proyek</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Kendala (Selesai/Total)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($projects as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $p['project_name'] ?></td>
                <td><?= date('d/m/Y', strtotime($p['start_date'])) ?></td>
                <td><?= $p['end_date'] ? date('d/m/Y', strtotime($p['end_date'])) : '-' ?></td>
                <td><?= ucfirst($p['status']) ?></td>
                <td><?= $p['progress'] ?>%</td>
                <td><?= $p['completed_issues'] ?>/<?= $p['total_issues'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari sistem.<br>
        PT Vitech Asia - Project Management System
    </div>
</body>
</html>