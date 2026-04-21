<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 9px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        .header h1 { color: #4CAF50; font-size: 18px; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; gap: 10px; }
        .stat-box { background: #f8f9fa; padding: 8px; text-align: center; width: 23%; border-radius: 5px; }
        .stat-box h3 { color: #4CAF50; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 8px; }
        th { background: #4CAF50; color: white; }
        .footer { text-align: center; margin-top: 20px; font-size: 7px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $title ?></h1>
        <p><?= $companyName ?> | Dicetak: <?= $printDate ?> | Oleh: <?= $printedBy ?></p>
    </div>

    <div class="stats">
        <div class="stat-box"><h3><?= $totalStaff ?></h3><small>Total Staff</small></div>
        <div class="stat-box"><h3><?= $totalCompleted ?>/<?= $totalTasks ?></h3><small>Tugas Selesai</small></div>
        <div class="stat-box"><h3><?= $totalOverdue ?></h3><small>Terlambat</small></div>
        <div class="stat-box"><h3><?= $avgCompletion ?>%</h3><small>Rata-rata</small></div>
    </div>

    <table>
        <thead>
            <tr><th>No</th><th>Nama</th><th>Posisi</th><th>Departemen</th><th>Total Tugas</th><th>Selesai</th><th>Terlambat</th><th>Rate</th></tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($staff as $s): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= ($s['first_name'] ?? $s['username']) . ' ' . ($s['last_name'] ?? '') ?></td>
                <td><?= $s['position_name'] ?? '-' ?></td>
                <td><?= $s['department_name'] ?? '-' ?></td>
                <td><?= $s['assigned_issues'] ?></td>
                <td><?= $s['completed_issues'] + $s['closed_issues'] ?></td>
                <td><?= $s['overdue_issues'] ?></td>
                <td><?= $s['completion_rate'] ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">Dokumen ini dicetak secara otomatis dari sistem | PT Vitech Asia</div>
</body>
</html>