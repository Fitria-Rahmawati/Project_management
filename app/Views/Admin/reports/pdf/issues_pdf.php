<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 8px; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #FF9800; padding-bottom: 10px; }
        .header h1 { color: #FF9800; font-size: 18px; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 15px; flex-wrap: wrap; gap: 5px; }
        .stat-box { background: #f8f9fa; padding: 5px; text-align: center; width: 18%; border-radius: 3px; }
        .stat-box h4 { font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 4px; text-align: left; font-size: 7px; }
        th { background: #FF9800; color: white; }
        .footer { text-align: center; margin-top: 20px; font-size: 7px; color: #999; }
        .status-open { color: #f44336; }
        .status-in_progress { color: #FF9800; }
        .status-done { color: #4CAF50; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $title ?></h1>
        <p><?= $companyName ?> | Dicetak: <?= $printDate ?> | Oleh: <?= $printedBy ?></p>
    </div>

    <div class="stats">
        <div class="stat-box"><h4><?= $stats['total'] ?></h4><small>Total Issue</small></div>
        <?php foreach($stats['by_status'] as $status => $count): ?>
        <div class="stat-box"><h4><?= $count ?></h4><small><?= ucfirst(str_replace('_', ' ', $status)) ?></small></div>
        <?php endforeach; ?>
        <?php foreach($stats['by_priority'] as $priority => $count): ?>
        <div class="stat-box"><h4><?= $count ?></h4><small>Priority <?= ucfirst($priority) ?></small></div>
        <?php endforeach; ?>
    </div>

    <table>
        <thead>
            <tr><th>ID</th><th>Judul</th><th>Proyek</th><th>Status</th><th>Prioritas</th><th>Pelapor</th><th>Penerima</th><th>Tanggal</th></tr>
        </thead>
        <tbody>
            <?php foreach($issues as $i): ?>
            <tr>
                <td>#<?= $i['id'] ?></td>
                <td><?= substr($i['title'], 0, 40) ?>...</td>
                <td><?= $i['project_name'] ?></td>
                <td class="status-<?= $i['status'] ?>"><?= str_replace('_', ' ', ucfirst($i['status'])) ?></td>
                <td><?= ucfirst($i['priority']) ?></td>
                <td><?= $i['reporter_name'] ?? '-' ?></td>
                <td><?= $i['assignee_name'] ?? '-' ?></td>
                <td><?= date('d/m/Y', strtotime($i['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">Dokumen ini dicetak secara otomatis dari sistem | PT Vitech Asia</div>
</body>
</html>