<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h3>Doctors List</h3>
<a href="/doctors/create" class="btn btn-success mb-3">Add Doctor</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th><th>Name</th><th>Expertise</th><th>Gender</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($doctors as $d): ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= $d['name'] ?></td>
            <td><?= $d['expertise'] ?></td>
            <td><?= $d['gender'] ?></td>
            <td>
                <a href="/doctors/edit/<?= $d['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="/doctors/delete/<?= $d['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
