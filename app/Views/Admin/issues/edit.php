<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Edit Issue</div>
    <div class="card-body">
        <form action="<?= base_url('admin/issues/update/'.$issue['id']) ?>" method="post">
            <input type="text"
                   name="title"
                   value="<?= $issue['title'] ?>"
                   class="form-control mb-3">
                   <textarea name="description"class="form-control mb-3"><?= $issue['description'] ?></textarea>
                   <select name="priority" class="form-control mb-3">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <select name="status" class="form-control mb-3">
                    <option value="open">Open</option>
                    <option value="progress">Progress</option>
                    <option value="closed">Closed</option>
                </select>
                <button class="btn btn-primary">Update</button>
                <a href="<?= base_url('admin/issues') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
</div>

<?= $this->endSection() ?>