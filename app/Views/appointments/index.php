<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h2 class="mb-4 fw-bold text-dark">Appointments</h2>

<a href="<?= site_url('appointments/create') ?>" class="btn btn-primary mb-4">
    <i class="bi bi-plus-lg"></i> New Appointment
</a>

<div class="mb-3 text-end">
    <a href="<?= site_url('appointments/export/csv') ?>" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-download"></i> Export CSV
    </a>
</div>

<?php
function renderAppointmentCard($title, $tableId, $appointments, $actions = true, $bgColor = '#fff3cd') {
?>

<div class="card mb-4 shadow-sm rounded-4 border-0">
    <div class="card-header" style="background-color: <?= $bgColor ?>; color: #333; font-weight: 600;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $title ?></h5>
            <div class="input-group input-group-sm" style="width: 450px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-person-badge text-muted"></i> Doctor ID
                </span>
                <input type="text" class="form-control search-input-doctor border-start-0" data-table="<?= $tableId ?>" placeholder="Search by Doctor ID">
                <button class="btn btn-light border-start-0 clear-doctor" type="button" data-table="<?= $tableId ?>"><i class="bi bi-x"></i></button>

                <span class="input-group-text bg-white border-end-0 ms-2">
                    <i class="bi bi-person text-muted"></i> Patient ID
                </span>
                <input type="text" class="form-control search-input-patient border-start-0" data-table="<?= $tableId ?>" placeholder="Search by Patient ID">
                <button class="btn btn-light border-start-0 clear-patient" type="button" data-table="<?= $tableId ?>"><i class="bi bi-x"></i></button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="<?= $tableId ?>">
            <thead class="table-light">
                <tr>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Problem</th>
                    <th>Start</th>
                    <th>End</th>
                    <?php if($actions): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($appointments)): ?>
                    <?php foreach($appointments as $app): ?>
                    <tr data-doctor-id="<?= esc($app['doctor_id']) ?>" data-patient-id="<?= esc($app['patient_id']) ?>">
                        <td><?= esc($app['doctor_name']) ?></td>
                        <td><?= esc($app['patient_name']) ?></td>
                        <td><?= esc($app['problem_description']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($app['start_datetime'])) ?></td>
                        <td><?= date('d M Y H:i', strtotime($app['end_datetime'])) ?></td>
                        <?php if($actions): ?>
                        <td>
                            <a href="/appointments/reschedule/<?= $app['id'] ?>" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="/appointments/complete/<?= $app['id'] ?>" class="btn btn-sm btn-success me-1"><i class="bi bi-check2-circle"></i></a>
                            <a href="/appointments/cancel/<?= $app['id'] ?>" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="<?= $actions ? 6 : 5 ?>" class="text-center text-muted py-3">No appointments found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php } 

// Render cards with light pastel colors
renderAppointmentCard("Pending Appointments", "pendingTable", $pending, true, '#ece5c6ff');     // Light Yellow
renderAppointmentCard("Completed Appointments", "completedTable", $completed, false, '#dbf1e0ff'); // Light Green
renderAppointmentCard("Cancelled Appointments", "cancelledTable", $cancelled, false, 'rgba(243, 221, 222, 1)'); // Light Red
?>

<style>
.card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease;
}

table tbody tr:hover {
    background-color: #f1f5f9;
}

.btn-sm {
    border-radius: 0.35rem;
    padding: 0.25rem 0.5rem;
}

.search-input-doctor:focus,
.search-input-patient:focus {
    border-color: #007bff;
    box-shadow: 0 0 6px rgba(0,123,255,0.3);
}

table thead th {
    font-weight: 600;
    text-transform: uppercase;
}

td {
    white-space: normal;
}
.input-group-text {
    font-size: 0.8rem;
    font-weight: 500;
}
</style>

<script>
function filterTable(tableId) {
    let table = document.getElementById(tableId);
    let doctorFilter = document.querySelector(`.search-input-doctor[data-table="${tableId}"]`).value.toLowerCase().trim();
    let patientFilter = document.querySelector(`.search-input-patient[data-table="${tableId}"]`).value.toLowerCase().trim();

    table.querySelectorAll('tbody tr').forEach(row => {
        let doctorId = row.dataset.doctorId?.toLowerCase() || "";
        let patientId = row.dataset.patientId?.toLowerCase() || "";

        // Both filters must match if filled
        let matchDoctor = !doctorFilter || doctorId.includes(doctorFilter);
        let matchPatient = !patientFilter || patientId.includes(patientFilter);

        row.style.display = (matchDoctor && matchPatient) ? "" : "none";
    });
}

// Doctor ID search
document.querySelectorAll('.search-input-doctor').forEach(input => {
    input.addEventListener('keyup', function() {
        filterTable(this.dataset.table);
    });
});

// Patient ID search
document.querySelectorAll('.search-input-patient').forEach(input => {
    input.addEventListener('keyup', function() {
        filterTable(this.dataset.table);
    });
});

// Clear doctor search
document.querySelectorAll('.clear-doctor').forEach(btn => {
    btn.addEventListener('click', function() {
        let input = document.querySelector(`.search-input-doctor[data-table="${this.dataset.table}"]`);
        input.value = "";
        filterTable(this.dataset.table);
    });
});

// Clear patient search
document.querySelectorAll('.clear-patient').forEach(btn => {
    btn.addEventListener('click', function() {
        let input = document.querySelector(`.search-input-patient[data-table="${this.dataset.table}"]`);
        input.value = "";
        filterTable(this.dataset.table);
    });
});
</script>

<?= $this->endSection() ?>
