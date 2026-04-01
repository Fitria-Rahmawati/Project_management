<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .issue-type-card {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid #eee;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
    }
    .issue-type-card:hover {
        border-color: #667eea;
        background: #f8f9ff;
    }
    .issue-type-card.selected {
        border-color: #667eea;
        background: #f0f3ff;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-exclamation-circle me-2 text-danger"></i>
            Report New Issue
        </h1>
        <a href="<?= base_url('staff/tasks') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card form-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Laporan Issue</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('staff/issues/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-4">
                            <label class="form-label">Issue Type</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="issue-type-card" onclick="selectType('task')" id="type-task">
                                        <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                                        <h6>Task</h6>
                                        <small>Pekerjaan biasa</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="issue-type-card" onclick="selectType('bug')" id="type-bug">
                                        <i class="fas fa-bug fa-2x text-danger mb-2"></i>
                                        <h6>Bug</h6>
                                        <small>Error / Masalah</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="issue-type-card" onclick="selectType('story')" id="type-story">
                                        <i class="fas fa-book fa-2x text-success mb-2"></i>
                                        <h6>Story</h6>
                                        <small>Fitur dari user</small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="issue_type" id="issue_type" value="task">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select" required>
                                <option value="">-- Pilih Project --</option>
                                <?php foreach($projects as $project): ?>
                                    <option value="<?= $project['id'] ?>"><?= $project['project_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Judul issue..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Jelaskan issue secara detail..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select" required>
                                <option value="Lowest">Lowest</option>
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                                <option value="Highest">Highest</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date (Optional)</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <a href="<?= base_url('staff/tasks') ?>" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-paper-plane me-2"></i>Submit Issue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectType(type) {
    document.getElementById('issue_type').value = type;
    
    const cards = ['task', 'bug', 'story'];
    cards.forEach(t => {
        const card = document.getElementById(`type-${t}`);
        card.classList.remove('selected');
    });
   
    document.getElementById(`type-${type}`).classList.add('selected');
}
selectType('task');
</script>

<?= $this->endSection() ?>