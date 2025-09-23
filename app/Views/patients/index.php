<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h3>Patients List</h3>
<a href="/patients/create" class="btn btn-success mb-3">Add Patient</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th><th>Name</th><th>Gender</th><th>Problem</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($patients as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['name'] ?></td>
            <td><?= $p['gender'] ?></td>
            <td><?= $p['problem_description'] ?></td>
            <td>
                <a href="/patients/edit/<?= $p['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="/patients/delete/<?= $p['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
