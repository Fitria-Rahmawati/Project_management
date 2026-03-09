<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        padding: 20px;
    }
    .table-project {
        font-size: 14px;
    }
    .project-type {
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 12px;
    }
    .type-internal {
        background: #e3f2fd;
        color: #1565c0;
    }
    .type-client {
        background: #e8f5e9;
        color: #2e7d32;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-project-diagram me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="/admin/projects/create" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Tambah Project
                </a>
            </div>
        </div>
    </div>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="row mb-4">
        <?php
        $totalProjects = count($projects);
        $completed = 0;
        $inProgress = 0;
        $planning = 0;
        $internal = 0;
        $client = 0;
        
        foreach($projects as $p) {
            if(($p['status'] ?? '') == 'completed') $completed++;
            if(($p['status'] ?? '') == 'in_progress') $inProgress++;
            if(($p['status'] ?? '') == 'planning') $planning++;
            if(($p['project_type'] ?? '') == 'internal') $internal++;
            if(($p['project_type'] ?? '') == 'client') $client++;
        }
        ?>
        
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="small opacity-75">Total Projects</span>
                            <h3 class="mt-2 mb-0"><?= $totalProjects ?></h3>
                        </div>
                        <div class="stat-icon bg-white text-primary">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="small opacity-75">Completed</span>
                            <h3 class="mt-2 mb-0"><?= $completed ?></h3>
                        </div>
                        <div class="stat-icon bg-white text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="small opacity-75">In Progress</span>
                            <h3 class="mt-2 mb-0"><?= $inProgress ?></h3>
                        </div>
                        <div class="stat-icon bg-white text-warning">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="small opacity-75">Internal / Client</span>
                            <h3 class="mt-2 mb-0"><?= $internal ?> / <?= $client ?></h3>
                        </div>
                        <div class="stat-icon bg-white text-info">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-card">
        <form method="get" action="<?= base_url('admin/projects') ?>">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-2">
                        <label class="form-label">Filter Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="planning" <?= ($filters['status'] ?? '') == 'planning' ? 'selected' : '' ?>>Planning</option>
                            <option value="in_progress" <?= ($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="completed" <?= ($filters['status'] ?? '') == 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2">
                        <label class="form-label">Filter Type</label>
                        <select name="type" class="form-select">
                            <option value="">Semua Type</option>
                            <option value="internal" <?= ($filters['type'] ?? '') == 'internal' ? 'selected' : '' ?>>Internal</option>
                            <option value="client" <?= ($filters['type'] ?? '') == 'client' ? 'selected' : '' ?>>Client</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2">
                        <label class="form-label">Filter Company</label>
                        <select name="company" class="form-select">
                            <option value="">Semua Company</option>
                            <?php foreach($companies as $company): ?>
                                <option value="<?= $company['id'] ?>" <?= ($filters['company'] ?? '') == $company['id'] ? 'selected' : '' ?>>
                                    <?= $company['company_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
            <?php if(!empty($filters['status']) || !empty($filters['type']) || !empty($filters['company'])): ?>
                <div class="row mt-2">
                    <div class="col-12">
                        <a href="<?= base_url('admin/projects') ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-project">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Project</th>
                            <th>Company</th>
                            <th>Project Manager</th>
                            <th>Status</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($projects)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data project</p>
                                    <a href="/admin/projects/create" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-2"></i>Tambah Project Pertama
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($projects as $index => $project): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= $project['project_name'] ?></strong>
                                        <br>
                                        <span class="project-type <?= ($project['project_type'] ?? 'internal') == 'internal' ? 'type-internal' : 'type-client' ?>">
                                            <i class="fas <?= ($project['project_type'] ?? '') == 'internal' ? 'fa-building' : 'fa-user-tie' ?> me-1"></i>
                                            <?= ucfirst($project['project_type'] ?? 'internal') ?>
                                        </span>
                                        <?php if(!empty($project['description'])): ?>
                                            <br>
                                            <small class="text-muted"><?= character_limiter($project['description'], 50) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= $project['company_name'] ?? 'Internal' ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <?php if(($project['company_type'] ?? '') == 'client'): ?>
                                                <i class="fas fa-user-tie me-1"></i>Contact: <?= $project['contact_person'] ?? '-' ?>
                                            <?php else: ?>
                                                <i class="fas fa-building me-1"></i>Internal
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php 
                                        $pmName = $project['manager_first_name'] ?? $project['manager_username'] ?? '-';
                                        if($pmName != '-'): 
                                        ?>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 30px; height: 30px; font-size: 12px;">
                                                    <?= strtoupper(substr($pmName, 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <?= $pmName ?>
                                                    <?php if(!empty($project['manager_last_name'])): ?>
                                                        <?= ' ' . $project['manager_last_name'] ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $statusClass = '';
                                        $statusIcon = '';
                                        switch($project['status'] ?? '') {
                                            case 'planning':
                                                $statusClass = 'bg-secondary';
                                                $statusIcon = 'fa-clock';
                                                $statusText = 'Planning';
                                                break;
                                            case 'in_progress':
                                                $statusClass = 'bg-warning text-dark';
                                                $statusIcon = 'fa-spinner';
                                                $statusText = 'In Progress';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-success';
                                                $statusIcon = 'fa-check-circle';
                                                $statusText = 'Completed';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'bg-danger';
                                                $statusIcon = 'fa-times-circle';
                                                $statusText = 'Cancelled';
                                                break;
                                            default:
                                                $statusClass = 'bg-info';
                                                $statusIcon = 'fa-question-circle';
                                                $statusText = ucfirst($project['status'] ?? 'Unknown');
                                        }
                                        ?>
                                        <span class="badge <?= $statusClass ?> p-2">
                                            <i class="fas <?= $statusIcon ?> me-1"></i>
                                            <?= $statusText ?>
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            <?= date('d/m/Y', strtotime($project['start_date'])) ?>
                                            <?php if(!empty($project['end_date'])): ?>
                                                - <?= date('d/m/Y', strtotime($project['end_date'])) ?>
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/admin/projects/<?= $project['id'] ?>" class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="/admin/projects/edit/<?= $project['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/admin/projects/delete/<?= $project['id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Yakin ingin menghapus project ini?')"
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Auto-hide flash messages -->
<script>
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>