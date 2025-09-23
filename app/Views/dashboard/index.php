<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Welcome to the Admin Dashboard</h2>

<div class="row g-4 mb-5">

    <!-- Doctors Card -->
    <div class="col-md-4">
        <div class="card stat-card p-4 text-center bg-light">
            <i class="bi bi-person-circle fs-1 text-primary"></i>
            <h5 class="mt-2">Doctors</h5>
            <h3><?= $doctorCount ?></h3>
            <a href="/doctors" class="btn btn-sm btn-primary mt-2">Manage</a>
        </div>
    </div>

    <!-- Patients Card -->
    <div class="col-md-4">
        <div class="card stat-card p-4 text-center bg-light">
            <i class="bi bi-people fs-1 text-success"></i>
            <h5 class="mt-2">Patients</h5>
            <h3><?= $patientCount ?></h3>
            <a href="/patients" class="btn btn-sm btn-success mt-2">Manage</a>
        </div>
    </div>

    <!-- Appointments Card with Dropdown -->
    <div class="col-md-4">
        <div class="card stat-card p-4 text-center bg-light position-relative">
            <div class="dropdown position-absolute top-0 end-0 p-2">
                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item <?= $selectedRange === 'today' ? 'active' : '' ?>" href="?range=today">Today</a></li>
                    <li><a class="dropdown-item <?= $selectedRange === 'week' ? 'active' : '' ?>" href="?range=week">This Week</a></li>
                    <li><a class="dropdown-item <?= $selectedRange === 'month' ? 'active' : '' ?>" href="?range=month">This Month</a></li>
                    <li><a class="dropdown-item <?= $selectedRange === '3months' ? 'active' : '' ?>" href="?range=3months">Last 3 Months</a></li>
                </ul>
            </div>
            <i class="bi bi-calendar-check fs-1 text-warning"></i>
            <h5 class="mt-2">Appointments</h5>
            <h3><?= $appointmentCount ?></h3>
            <a href="/appointments" class="btn btn-sm btn-warning mt-2">Manage</a>
        </div>
    </div>

</div>

<h4>Appointments (<?= ucfirst($selectedRange) ?>)</h4>
<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>appointment id</th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>problem_description</th>
            <th>Start</th>
            <th>End</th>
            <th>status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($recentAppointments)): ?>
            <?php foreach($recentAppointments as $app): ?>
            <tr>
                <td><?= $app['id'] ?></td>
                <td><?= $app['doctor_name'] ?></td>
                <td><?= $app['patient_name'] ?></td>
                <td><?= $app['problem_description']?></td>
                
                <td><?= date('d M Y H:i', strtotime($app['start_datetime'])) ?></td>
                <td><?= date('d M Y H:i', strtotime($app['end_datetime'])) ?></td>
                <td><?= $app['status']?></td>
                

            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">No appointments found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<?= $this->endSection() ?>
