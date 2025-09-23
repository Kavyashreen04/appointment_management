<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Welcome to the Admin Dashboard</h2>

<div class="row g-4 mb-5">

    <!-- Doctors Card -->
    <div class="col-md-4">
        <div class="card stat-card p-4 bg-light h-100 d-flex flex-column text-center">
            <i class="bi bi-person-circle fs-1 text-primary"></i>
            <h5 class="mt-2">Doctors</h5>
            <h3><?= $doctorCount ?></h3>
            <div class="mt-auto">
                <a href="/doctors" class="btn btn-sm btn-primary w-100">Manage</a>
            </div>
        </div>
    </div>

    <!-- Patients Card -->
    <div class="col-md-4">
        <div class="card stat-card p-4 bg-light h-100 d-flex flex-column text-center">
            <i class="bi bi-people fs-1 text-success"></i>
            <h5 class="mt-2">Patients</h5>
            <h3><?= $patientCount ?></h3>
            <div class="mt-auto">
                <a href="/patients" class="btn btn-sm btn-success w-100">Manage</a>
            </div>
        </div>
    </div>

    <!-- Appointments Card with Dropdown + Counts -->
    <div class="col-md-4">
        <div class="card stat-card p-4 bg-light h-100 d-flex flex-column position-relative">

            <!-- Dropdown for time range -->
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

            <i class="bi bi-calendar-check fs-1 text-warning mt-2"></i>
            <h5 class="mt-2 text-center">Appointments</h5>

            <!-- Counts (dynamic based on selected range) -->
            <div class="mt-3 text-start">
                <p class="mb-1">Pending: <span class="fw-bold"><?= $pendingCount ?></span></p>
                <p class="mb-1">Completed: <span class="fw-bold"><?= $completedCount ?></span></p>
                <p class="mb-1">Canceled: <span class="fw-bold"><?= $canceledCount ?></span></p>
                <p class="mb-1">Total: <span class="fw-bold"><?= $totalCount ?></span></p>
            </div>

            <div class="mt-auto">
                <a href="/appointments" class="btn btn-sm btn-warning w-100">Manage Appointments</a>
            </div>
        </div>
    </div>

</div>

<h4>Appointments (<?= ucfirst($selectedRange) ?>)</h4>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Problem Description</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($recentAppointments)): ?>
                <?php foreach($recentAppointments as $app): ?>
                <tr>
                    <td><?= $app['id'] ?></td>
                    <td><?= $app['doctor_name'] ?></td>
                    <td><?= $app['patient_name'] ?></td>
                    <td><?= $app['problem_description'] ?></td>
                    <td><?= date('d M Y H:i', strtotime($app['start_datetime'])) ?></td>
                    <td><?= date('d M Y H:i', strtotime($app['end_datetime'])) ?></td>
                    <td><?= ucfirst($app['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">No appointments found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
