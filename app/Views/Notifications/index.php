<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* ==================== NOTIFICATION PAGE STYLES ==================== */
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }
    .notification-stats {
        display: flex;
        gap: 15px;
    }
    .stat-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }
    .stat-badge.all { background: #e3e6f0; color: #5a5c69; }
    .stat-badge.unread { background: #e3f2fd; color: #1976d2; }
    .stat-badge.read { background: #e8f5e9; color: #388e3c; }
    
    .notification-item {
        transition: all 0.3s;
        border-left: 3px solid transparent;
        margin-bottom: 10px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .notification-item.unread {
        background: #f0f7ff;
        border-left-color: #4e73df;
    }
    .notification-item:hover {
        background: #f8f9fc;
        transform: translateX(3px);
    }
    .notification-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .notification-icon.contract { background: #fff3e0; color: #f6c23e; }
    .notification-icon.task { background: #e3f2fd; color: #2196f3; }
    .notification-icon.device { background: #e8f5e9; color: #4caf50; }
    .notification-icon.issue { background: #ffebee; color: #f44336; }
    .notification-icon.comment { background: #e8eaf6; color: #3f51b5; }
    .notification-icon.default { background: #e3e6f0; color: #9e9e9e; }
    
    .notification-title {
        font-weight: 600;
        margin-bottom: 4px;
    }
    .notification-message {
        font-size: 13px;
        color: #666;
        margin-bottom: 6px;
    }
    .notification-time {
        font-size: 11px;
        color: #999;
    }
    .mark-read-btn {
        opacity: 0;
        transition: opacity 0.3s;
    }
    .notification-item:hover .mark-read-btn {
        opacity: 1;
    }
    .btn-mark-all {
        background: #f8f9fc;
        border: 1px solid #e3e6f0;
        padding: 8px 20px;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .btn-mark-all:hover {
        background: #e3e6f0;
        transform: translateY(-2px);
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 64px;
        color: #e3e6f0;
        margin-bottom: 20px;
    }
    .empty-state h4 {
        font-size: 18px;
        color: #5a5c69;
        margin-bottom: 8px;
    }
    .empty-state p {
        color: #858796;
    }
    
    @media (max-width: 768px) {
        .notification-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .mark-read-btn {
            opacity: 1;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="notification-header">
        <div>
            <h1 class="h2 mb-1">
                <i class="fas fa-bell me-2 text-primary"></i>
                Notifikasi
            </h1>
            <p class="text-muted">Semua notifikasi dan aktivitas terbaru Anda</p>
        </div>
        <div class="d-flex gap-2">
            <div class="notification-stats">
                <span class="stat-badge all">📋 Total: <?= $totalNotif ?? 0 ?></span>
                <span class="stat-badge unread">🆕 Belum Dibaca: <?= $unreadCount ?? 0 ?></span>
            </div>
            <?php if(($unreadCount ?? 0) > 0): ?>
                <button class="btn-mark-all" id="markAllRead">
                    <i class="fas fa-check-double me-2 text-primary"></i>Tandai Semua Dibaca
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="card shadow">
        <div class="card-body p-0">
            <?php if(empty($notifications)): ?>
                <div class="empty-state">
                    <i class="fas fa-bell-slash"></i>
                    <h4>Belum Ada Notifikasi</h4>
                    <p>Anda akan menerima notifikasi ketika ada aktivitas baru</p>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach($notifications as $notif): ?>
                        <?php
                        // Set icon berdasarkan type
                        $iconType = 'default';
                        $iconClass = 'default';
                        if(strpos($notif['type'], 'contract') !== false) {
                            $iconType = 'contract';
                            $iconClass = 'contract';
                        } elseif(strpos($notif['type'], 'task') !== false || strpos($notif['type'], 'assigned') !== false) {
                            $iconType = 'task';
                            $iconClass = 'task';
                        } elseif(strpos($notif['type'], 'device') !== false || strpos($notif['type'], 'login') !== false) {
                            $iconType = 'device';
                            $iconClass = 'device';
                        } elseif(strpos($notif['type'], 'issue') !== false) {
                            $iconType = 'issue';
                            $iconClass = 'issue';
                        } elseif(strpos($notif['type'], 'comment') !== false) {
                            $iconType = 'comment';
                            $iconClass = 'comment';
                        }
                        
                        $iconMap = [
                            'contract' => ['icon' => 'fa-file-contract', 'color' => '#f6c23e'],
                            'task' => ['icon' => 'fa-tasks', 'color' => '#2196f3'],
                            'device' => ['icon' => 'fa-laptop', 'color' => '#4caf50'],
                            'issue' => ['icon' => 'fa-exclamation-circle', 'color' => '#f44336'],
                            'comment' => ['icon' => 'fa-comment', 'color' => '#3f51b5'],
                            'default' => ['icon' => 'fa-bell', 'color' => '#9e9e9e']
                        ];
                        $icon = $iconMap[$iconType]['icon'];
                        $iconColor = $iconMap[$iconType]['color'];
                        ?>
                        <div class="list-group-item notification-item <?= !$notif['is_read'] ? 'unread' : '' ?>" 
                             data-id="<?= $notif['id'] ?>"
                             id="notif-<?= $notif['id'] ?>">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-3 flex-grow-1">
                                    <div class="notification-icon <?= $iconClass ?>" style="background: <?= $iconColor ?>10;">
                                        <i class="fas <?= $icon ?>" style="color: <?= $iconColor ?>;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                            <div class="notification-title">
                                                <?= esc(is_scalar($notif['title']) ? $notif['title'] : (is_array($notif['title']) ? json_encode($notif['title'], JSON_UNESCAPED_UNICODE) : '')) ?>
                                                <?php if(!$notif['is_read']): ?>
                                                    <span class="badge bg-primary ms-2" style="font-size: 9px;">Baru</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="notification-time">
                                                <i class="far fa-clock me-1"></i>
                                                <?= $this->timeAgo($notif['created_at']) ?>
                                            </div>
                                        </div>
                                        <div class="notification-message">
                                            <?= esc(is_scalar($notif['message']) ? $notif['message'] : (is_array($notif['message']) ? json_encode($notif['message'], JSON_UNESCAPED_UNICODE) : '')) ?>
                                        </div>
                                        <div class="d-flex gap-3 mt-2">
                                            <?php if($notif['link']): ?>
                                                <a href="<?= $notif['link'] ?>" class="text-decoration-none small" style="color: #4e73df;">
                                                    <i class="fas fa-arrow-right me-1"></i> Lihat Detail
                                                </a>
                                            <?php endif; ?>
                                            <?php if(!$notif['is_read']): ?>
                                                <button class="btn btn-sm btn-link text-primary p-0 mark-read-btn" 
                                                        onclick="markAsRead(<?= $notif['id'] ?>)">
                                                    <i class="fas fa-check-circle me-1"></i> Tandai Dibaca
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Mark single notification as read
function markAsRead(id) {
    fetch('<?= base_url('notifications/mark-read') ?>/' + id, { 
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('notif-' + id)?.classList.remove('unread');
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

// Mark all notifications as read
document.getElementById('markAllRead')?.addEventListener('click', function() {
    fetch('<?= base_url('notifications/mark-all-read') ?>', { 
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

<?php
// Helper function untuk time ago
if (!function_exists('timeAgo')) {
    function timeAgo($datetime, $full = false) {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        
        $weeks = floor($diff->d / 7);
        $diff->d -= $weeks * 7;
        
        $string = [];
        if ($diff->y) {
            $string['y'] = $diff->y . ' tahun';
        }
        if ($diff->m) {
            $string['m'] = $diff->m . ' bulan';
        }
        if ($weeks) {
            $string['w'] = $weeks . ' minggu';
        }
        if ($diff->d) {
            $string['d'] = $diff->d . ' hari';
        }
        if ($diff->h) {
            $string['h'] = $diff->h . ' jam';
        }
        if ($diff->i) {
            $string['i'] = $diff->i . ' menit';
        }
        if ($diff->s) {
            $string['s'] = $diff->s . ' detik';
        }
        
        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }
}
// Register helper untuk view
$this->timeAgo = function($datetime) {
    return timeAgo($datetime);
};
?>

<?= $this->endSection() ?>