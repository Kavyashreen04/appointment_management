<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h2 class="mb-4 fw-bold text-dark">Appointments</h2>

<a href="<?= site_url('appointments/create') ?>" class="btn btn-primary mb-4">
    <i class="bi bi-plus-lg"></i> New Appointment
</a>

<!-- ================= Pending Appointments ================= -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-dark fw-bold">
        Pending Appointments
    </div>
    <div class="card-body p-0">
        <?php if (!empty($pending)): ?>
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Problem</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pending as $appt): ?>
                    <tr>
                        <td><?= esc($appt['patient_name']) ?></td>
                        <td><?= esc($appt['doctor_name']) ?></td>
                        <td><?= esc($appt['start_datetime']) ?></td>
                        <td><?= esc($appt['end_datetime']) ?></td>
                        <td><?= esc($appt['problem_description']) ?></td>
                        <td>
                            <!-- ✅ Done Button -->
                            <a href="<?= site_url('appointments/complete/' . $appt['id']) ?>" 
                               class="btn btn-success btn-sm">
                                <i class="bi bi-check2-circle"></i> Done
                            </a>
                            <!-- Optional: Reschedule Button -->
                            <a href="<?= site_url('appointments/create/' . $appt['id']) ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Reschedule
                            </a>
                            <!-- Cancel Button -->
                            <a href="<?= site_url('appointments/delete/' . $appt['id']) ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted p-3 mb-0">No pending appointments.</p>
        <?php endif; ?>
    </div>
</div>

<!-- ================= Completed Appointments ================= -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white fw-bold">
        Completed Appointments
    </div>
    <div class="card-body p-0">
        <?php if (!empty($completed)): ?>
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Problem</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($completed as $appt): ?>
                    <tr>
                        <td><?= esc($appt['patient_name']) ?></td>
                        <td><?= esc($appt['doctor_name']) ?></td>
                        <td><?= esc($appt['start_datetime']) ?></td>
                        <td><?= esc($appt['end_datetime']) ?></td>
                        <td><?= esc($appt['problem_description']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted p-3 mb-0">No completed appointments.</p>
        <?php endif; ?>
    </div>
</div>

<!-- ================= Cancelled Appointments ================= -->
<div class="card shadow-sm">
    <div class="card-header bg-danger text-white fw-bold">
        Cancelled Appointments
    </div>
    <div class="card-body p-0">
        <?php if (!empty($cancelled)): ?>
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Problem</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cancelled as $appt): ?>
                    <tr>
                        <td><?= esc($appt['patient_name']) ?></td>
                        <td><?= esc($appt['doctor_name']) ?></td>
                        <td><?= esc($appt['start_datetime']) ?></td>
                        <td><?= esc($appt['end_datetime']) ?></td>
                        <td><?= esc($appt['problem_description']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted p-3 mb-0">No cancelled appointments.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
