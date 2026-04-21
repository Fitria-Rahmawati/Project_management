<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Kendala</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #e74a3b; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #e74a3b; margin: 0; font-size: 18px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border: 1px solid #ddd; vertical-align: top; }
        .info-table td:first-child { width: 130px; background: #f5f5f5; font-weight: bold; }
        .section-title { background: #e74a3b; color: white; padding: 6px 10px; margin: 15px 0 10px; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .priority-high { color: #e74a3b; font-weight: bold; }
        .priority-medium { color: #f6c23e; font-weight: bold; }
        .priority-low { color: #1cc88a; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DETAIL KENDALA / ISSUE</h1>
        <p><?= $companyName ?> | Dicetak: <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <table class="info-table">
        <tr><td>ID Kendala</td><td>#<?= $issue['id'] ?></td></tr>
        <tr><td>Proyek</td><td><?= $issue['project_name'] ?></td></tr>
        <tr><td>Judul Kendala</td><td><?= $issue['title'] ?></td></tr>
        <tr><td>Prioritas</td><td class="priority-<?= $issue['priority'] ?>"><?= ucfirst($issue['priority']) ?></td></tr>
        <tr><td>Status</td><td><?= str_replace('_', ' ', ucfirst($issue['status'])) ?></td></tr>
        <tr><td>Pelapor</td><td><?= session()->get('username') ?></td></tr>
        <tr><td>Tanggal Lapor</td><td><?= date('d F Y H:i', strtotime($issue['created_at'])) ?></td></tr>
        <tr><td>Penerima</td><td><?= $issue['assignee_name'] ?? 'Belum ditugaskan' ?></td></tr>
        <?php if($issue['due_date']): ?>
        <tr><td>Deadline</td><td><?= date('d F Y', strtotime($issue['due_date'])) ?></td></tr>
        <?php endif; ?>
    </table>

    <div class="section-title">DESKRIPSI KENDALA</div>
    <p><?= nl2br($issue['description']) ?></p>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari sistem.<br>
        PT Vitech Asia - Project Management System
    </div>
</body>
</html>