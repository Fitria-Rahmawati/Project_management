<?php 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kinerja Tim</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
        }
        .report-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .report-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-subtitle {
            color: #666;
            font-size: 14px;
        }
        .summary-stats {
            display: flex;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 8px;
            min-width: 150px;
            background: #f9f9f9;
        }
        .stat-number {
            font-size: 28px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .badge-completion-high {
            background: #28a745;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .badge-completion-medium {
            background: #ffc107;
            color: #333;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .badge-completion-low {
            background: #dc3545;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .rounded-circle {
            width: 32px;
            height: 32px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="report-header">
        <div class="report-title">Laporan Kinerja Tim</div>
        <div class="report-subtitle">
            Periode: <?= date('d F Y') ?> | Total <?= count($staff) ?> anggota tim aktif
            <?php if(!empty($filter_period) && $filter_period != 'all'): ?>
                <br>Filter: <?= ucfirst(str_replace('_', ' ', $filter_period)) ?>
            <?php endif; ?>
            <?php if(!empty($filter_dept_name)): ?>
                | Departemen: <?= $filter_dept_name ?>
            <?php endif; ?>
            <?php if(!empty($filter_pos_name)): ?>
                | Posisi: <?= $filter_pos_name ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="summary-stats">
        <div class="stat-box">
            <div class="stat-number"><?= count($staff) ?></div>
            <div class="stat-label">Total Staff</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?= array_sum(array_column($staff, 'assigned_issues')) ?></div>
            <div class="stat-label">Total Tugas</div>
        </div>
        <div class="stat-box">
            <div class="stat-number text-success"><?= array_sum(array_column($staff, 'completed_issues')) + array_sum(array_column($staff, 'closed_issues')) ?></div>
            <div class="stat-label">Tugas Selesai</div>
        </div>
        <div class="stat-box">
            <div class="stat-number text-danger"><?= array_sum(array_column($staff, 'overdue_issues')) ?></div>
            <div class="stat-label">Tugas Terlambat</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?= round(array_sum(array_column($staff, 'completion_rate')) / max(1, count($staff)), 1) ?>%</div>
            <div class="stat-label">Rata-rata Completion</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Staff</th>
                <th>Posisi</th>
                <th>Departemen</th>
                <th class="text-center">Tugas</th>
                <th class="text-center">Selesai</th>
                <th class="text-center">Terlambat</th>
                <th class="text-center">Completion</th>
                <th class="text-center">Jam Kerja</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($staff)): ?>
                <tr>
                    <td colspan="9" class="text-center">Belum ada data kinerja tim</td>
                </tr>
            <?php else: ?>
                <?php foreach($staff as $i => $member): ?>
                    <tr>
                        <td class="text-center"><?= $i+1 ?></td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div class="rounded-circle">
                                    <?= strtoupper(substr($member['first_name'] ?? $member['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <strong><?= $member['first_name'] ?? $member['username'] ?> <?= $member['last_name'] ?? '' ?></strong>
                                    <br>
                                    <small><?= $member['email'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?= $member['position_name'] ?? '-' ?></td>
                        <td><?= $member['department_name'] ?? '-' ?></td>
                        <td class="text-center"><?= $member['assigned_issues'] ?></td>
                        <td class="text-center"><?= ($member['completed_issues'] ?? 0) + ($member['closed_issues'] ?? 0) ?></td>
                        <td class="text-center"><?= $member['overdue_issues'] ?? 0 ?></td>
                        <td class="text-center">
                            <?php $rate = $member['completion_rate'] ?? 0; ?>
                            <span class="<?= $rate >= 70 ? 'badge-completion-high' : ($rate >= 50 ? 'badge-completion-medium' : 'badge-completion-low') ?>">
                                <?= $rate ?>%
                            </span>
                        </td>
                        <td class="text-center"><?= $member['total_hours'] ?? 0 ?> jam</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #999;">
        Dicetak pada: <?= date('d/m/Y H:i:s') ?>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; margin-right: 10px; cursor: pointer;">🖨️ Print</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">✖️ Close</button>
    </div>
</body>
</html>