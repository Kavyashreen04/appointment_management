<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h3><?= isset($doctor) ? 'Edit Doctor' : 'Add Doctor' ?></h3>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="<?= isset($doctor) ? '/doctors/update/'.$doctor['id'] : '/doctors/store' ?>">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="<?= isset($doctor) ? $doctor['name'] : old('name') ?>">
    </div>

    <div class="mb-3">
        <label>Expertise</label>
        <input type="text" name="expertise" class="form-control" required value="<?= isset($doctor) ? $doctor['expertise'] : old('expertise') ?>">
    </div>

    <div class="mb-3">
        <label>Gender</label>
        <select name="gender" class="form-select" required>
            <option value="">Select Gender</option>
            <option value="Male" <?= isset($doctor) && $doctor['gender']=='Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= isset($doctor) && $doctor['gender']=='Female' ? 'selected' : '' ?>>Female</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success"><?= isset($doctor) ? 'Update' : 'Add' ?></button>
</form>

<?= $this->endSection() ?>
