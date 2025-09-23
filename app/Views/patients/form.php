<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h3><?= isset($patient) ? 'Edit Patient' : 'Add Patient' ?></h3>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= isset($patient) ? '/patients/update/'.$patient['id'] : '/patients/store' ?>" method="POST">

    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="<?= isset($patient) ? $patient['name'] : old('name') ?>">
    </div>

    <div class="mb-3">
        <label>Gender</label>
        <select name="gender" class="form-select" required>
            <option value="">Select Gender</option>
            <option value="Male" <?= isset($patient) && $patient['gender']=='Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= isset($patient) && $patient['gender']=='Female' ? 'selected' : '' ?>>Female</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Problem Description</label>
        <textarea name="problem_description" class="form-control" required><?= isset($patient) ? $patient['problem_description'] : old('problem_description') ?></textarea>
    </div>

    <button type="submit" class="btn btn-success"><?= isset($patient) ? 'Update' : 'Add' ?></button>
</form>

<?= $this->endSection() ?>
