<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 9px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2196F3; padding-bottom: 10px; }
        .header h1 { color: #2196F3; font-size: 18px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 8px; }
        th { background: #2196F3; color: white; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 7px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .status-active { color: #2196F3; }
        .status-completed { color: #4CAF50; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $title ?></h1>
        <p><?= $companyName ?> | Dicetak: <?= $printDate ?> | Oleh: <?= $printedBy ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Proyek</th>
                <th>Client</th>
                <th>Project Manager</th>
                <th>Status</th>
                <th>Total Issue</th>
                <th>Selesai</th>
                <th>Terlambat</th>
                <th>Progress</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($projects as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $p['project_name'] ?></td>
                <td><?= $p['company_name'] ?? '-' ?></td>
                <td><?= $p['manager_name'] ?? '-' ?></td>
                <td class="status-<?= $p['status'] == 'completed' ? 'completed' : 'active' ?>"><?= ucfirst($p['status']) ?></td>
                <td><?= $p['total_issues'] ?></td>
                <td><?= ($p['completed_issues'] + $p['closed_issues']) ?></td>
                <td><?= $p['overdue_issues'] ?></td>
                <td><?= $p['progress'] ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">Dokumen ini dicetak secara otomatis dari sistem | PT Vitech Asia</div>
</body>
</html>