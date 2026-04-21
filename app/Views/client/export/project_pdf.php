<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Proyek</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #36b9cc; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #36b9cc; margin: 0; font-size: 18px; }
        .header p { color: #666; font-size: 10px; margin: 5px 0 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border: 1px solid #ddd; vertical-align: top; }
        .info-table td:first-child { width: 140px; background: #f5f5f5; font-weight: bold; }
        .section-title { background: #36b9cc; color: white; padding: 6px 10px; margin: 15px 0 10px; font-weight: bold; font-size: 12px; }
        .comment-box { background: #f9f9f9; border-left: 3px solid #36b9cc; padding: 10px; margin: 10px 0; }
        .issue-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .issue-table th, .issue-table td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 10px; }
        .issue-table th { background: #f5f5f5; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
        .priority-high { color: #e74a3b; font-weight: bold; }
        .priority-medium { color: #f6c23e; font-weight: bold; }
        .priority-low { color: #1cc88a; font-weight: bold; }
        .status-done { color: #1cc88a; }
        .status-progress { color: #f6c23e; }
        .status-open { color: #e74a3b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DETAIL PROYEK</h1>
        <p><?= $companyName ?> | Dicetak: <?= date('d/m/Y H:i:s') ?> | Oleh: <?= session()->get('username') ?></p>
    </div>

    <table class="info-table">
        <tr><td>Nama Proyek</td><td><?= $project['project_name'] ?></td></tr>
        <tr><td>Tanggal Mulai</td><td><?= date('d F Y', strtotime($project['start_date'])) ?></td></tr>
        <tr><td>Tanggal Berakhir</td><td><?= $project['end_date'] ? date('d F Y', strtotime($project['end_date'])) : 'Belum ditentukan' ?></td></tr>
        <tr><td>Status</td><td><?= ucfirst($project['status']) ?></td></tr>
        <tr><td>Progress</td><td><?= $project['progress'] ?>%</td></tr>
        <tr><td>Deskripsi</td><td><?= nl2br($project['description'] ?? '-') ?></td></tr>
    </table>

    <div class="section-title">KOMENTAR / MASUKAN</div>
    <?php if(!empty($project['client_comments'])): ?>
        <div class="comment-box">
            <strong>Komentar Anda:</strong><br>
            <?= nl2br($project['client_comments']) ?><br>
            <small>Terakhir diperbarui: <?= date('d/m/Y H:i', strtotime($project['comments_updated_at'])) ?></small>
        </div>
    <?php else: ?>
        <p><em>Tidak ada komentar</em></p>
    <?php endif; ?>

    <div class="section-title">DAFTAR KENDALA / ISSUES</div>
    <?php if(!empty($issues)): ?>
        <table class="issue-table">
            <thead>
                <tr><th>No</th><th>Judul</th><th>Prioritas</th><th>Status</th><th>Penerima</th><th>Deadline</th></tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($issues as $i): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $i['title'] ?></td>
                    <td class="priority-<?= $i['priority'] ?>"><?= ucfirst($i['priority']) ?></td>
                    <td class="status-<?= $i['status'] ?>"><?= str_replace('_', ' ', ucfirst($i['status'])) ?></td>
                    <td><?= $i['assignee_name'] ?? '-' ?></td>
                    <td><?= $i['due_date'] ? date('d/m/Y', strtotime($i['due_date'])) : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><em>Tidak ada kendala</em></p>
    <?php endif; ?>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari sistem.<br>
        PT Vitech Asia - Project Management System
    </div>
</body>
</html>