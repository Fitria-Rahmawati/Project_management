<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 9px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #9C27B0; padding-bottom: 10px; }
        .header h1 { color: #9C27B0; font-size: 18px; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; gap: 10px; }
        .stat-box { background: #f8f9fa; padding: 8px; text-align: center; width: 23%; border-radius: 5px; }
        .stat-box h3 { color: #9C27B0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 8px; }
        th { background: #9C27B0; color: white; }
        .footer { text-align: center; margin-top: 20px; font-size: 7px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $title ?></h1>
        <p><?= $companyName ?> | Dicetak: <?= $printDate ?> | Oleh: <?= $printedBy ?></p>
    </div>

    <div class="stats">
        <div class="stat-box"><h3><?= $totalClients ?></h3><small>Total Client</small></div>
        <div class="stat-box"><h3><?= $totalProjects ?></h3><small>Total Proyek</small></div>
        <div class="stat-box"><h3><?= $totalIssues ?></h3><small>Total Issue</small></div>
        <div class="stat-box"><h3><?= $totalCompleted ?></h3><small>Issue Selesai</small></div>
    </div>

    <table>
        <thead>
            <tr><th>No</th><th>Perusahaan</th><th>Email</th><th>Telepon</th><th>Total Proyek</th><th>Total Issue</th><th>Issue Selesai</th><th>Completion Rate</th></tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($clients as $c): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $c['company_name'] ?></td>
                <td><?= $c['email'] ?></td>
                <td><?= $c['phone'] ?? '-' ?></td>
                <td><?= $c['total_projects'] ?></td>
                <td><?= $c['total_issues'] ?></td>
                <td><?= $c['completed_issues'] + $c['closed_issues'] ?></td>
                <td><?= $c['completion_rate'] ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">Dokumen ini dicetak secara otomatis dari sistem | PT Vitech Asia</div>
</body>
</html>