<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h3>Edit Project</h3>

<form action="<?= base_url('admin/projects/update/'.$projects['id']) ?>" method="post">
       <div class="form-group">
              <label>Nama Project</label>
              <input type="text" name="project_name" class="form-control"
              value="<?= $projects['project_name'] ?>" required>
       </div>
       <div class="form-group">
              <label>Perusahaan</label>
              <select name="company_id" class="form-control">
                     <?php foreach($companies as $c): ?>
                            <option value="<?= $c['id'] ?>"
                            <?= $projects['company_id'] == $c['id'] ? 'selected' : '' ?>>
                            <?= $c['company_name'] ?>
                     </option>
                     <?php endforeach ?>
              </select>
       </div>
       <div class="form-group">
              <label>Project Manager</label>
              <select name="project_manager_id" class="form-control">
                     <?php foreach($pms as $pm): ?>
                            <option value="<?= $pm['id'] ?>"
                            <?= $projects['project_manager_id'] == $pm['id'] ? 'selected' : '' ?>>
                            <?= $pm['first_name'] . ' ' . $pm['last_name'] ?>
                     </option>
                     <?php endforeach ?>
              </select>
       </div>
       <button class="btn btn-primary">Update Project</button>
</form>

<?= $this->endSection() ?>