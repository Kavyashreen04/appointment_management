<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h2 class="mb-4"><?= isset($appointment) && $appointment ? 'Reschedule Appointment' : 'New Appointment' ?></h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form action="<?= site_url('appointments/store') ?>" method="post" class="card p-4 shadow-sm" id="apptForm">
    <?= csrf_field() ?>

    <?php $old = function($key, $fallback = null) use($appointment) {
        $val = old($key);
        if ($val !== null && $val !== '') return $val;
        return $appointment[$key] ?? $fallback;
    }; ?>

    <?php if (isset($appointment) && $appointment): ?>
        <input type="hidden" name="id" value="<?= esc($appointment['id']) ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="doctor_id" class="form-label">Doctor</label>
        <select name="doctor_id" id="doctor_id" class="form-select" required>
            <option value="">Select Doctor</option>
            <?php $selDoc = $old('doctor_id'); ?>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= $doctor['id'] ?>" <?= ($selDoc == $doctor['id']) ? 'selected' : '' ?>>
                    <?= esc($doctor['name']) ?> (<?= esc($doctor['expertise']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="patient_id" class="form-label">Patient</label>
        <select name="patient_id" id="patient_id" class="form-select" required>
            <option value="">Select Patient</option>
            <?php $selPat = $old('patient_id'); ?>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['id'] ?>"
                    data-problem="<?= esc($patient['problem_description'] ?? '') ?>"
                    <?= ($selPat == $patient['id']) ? 'selected' : '' ?>>
                    <?= esc($patient['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="problem_description" class="form-label">Problem Description</label>
        <textarea name="problem_description" id="problem_description" class="form-control" rows="3" required><?= esc($old('problem_description', '')) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="start_datetime" class="form-label">Start Date & Time</label>
        <input type="datetime-local" name="start_datetime" id="start_datetime" class="form-control" required
               value="<?= esc($old('start_datetime', (isset($appointment) ? date('Y-m-d\TH:i', strtotime($appointment['start_datetime'])) : ''))) ?>">
    </div>

    <div class="mb-3">
        <label for="end_datetime" class="form-label">End Date & Time</label>
        <input type="datetime-local" name="end_datetime" id="end_datetime" class="form-control" required
               value="<?= esc($old('end_datetime', (isset($appointment) ? date('Y-m-d\TH:i', strtotime($appointment['end_datetime'])) : ''))) ?>">
        <div id="timeError" class="invalid-feedback d-none">End time must be after start time.</div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="<?= site_url('appointments') ?>" class="btn btn-secondary me-2">Cancel</a>
        <button type="submit" id="saveBtn" class="btn btn-primary"><?= isset($appointment) ? 'Update Appointment' : 'Create Appointment' ?></button>
    </div>
</form>

<script>
(function() {
    const patientSelect = document.getElementById('patient_id');
    const problemTextarea = document.getElementById('problem_description');
    const startInput = document.getElementById('start_datetime');
    const endInput = document.getElementById('end_datetime');
    const saveBtn = document.getElementById('saveBtn');
    const timeError = document.getElementById('timeError');

    // Auto-fill problem when patient changes (uses data attribute)
    patientSelect.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const problem = opt ? opt.getAttribute('data-problem') || '' : '';
        problemTextarea.value = problem;
    });

    // Validate times: end must be after start
    function validateTimes() {
        const s = startInput.value;
        const e = endInput.value;
        // if either empty, enable submit (server will also validate required)
        if (!s || !e) {
            timeError.classList.add('d-none');
            startInput.classList.remove('is-invalid');
            endInput.classList.remove('is-invalid');
            saveBtn.disabled = false;
            return true;
        }

        const sTs = Date.parse(s);
        const eTs = Date.parse(e);
        if (isNaN(sTs) || isNaN(eTs)) {
            // invalid format -> leave to server
            timeError.classList.add('d-none');
            startInput.classList.remove('is-invalid');
            endInput.classList.remove('is-invalid');
            saveBtn.disabled = false;
            return true;
        }

        if (eTs <= sTs) {
            timeError.classList.remove('d-none');
            startInput.classList.add('is-invalid');
            endInput.classList.add('is-invalid');
            saveBtn.disabled = true;
            return false;
        } else {
            timeError.classList.add('d-none');
            startInput.classList.remove('is-invalid');
            endInput.classList.remove('is-invalid');
            saveBtn.disabled = false;
            return true;
        }
    }

    // set end.min to start value when start changes
    startInput.addEventListener('change', function() {
        if (this.value) {
            endInput.min = this.value;
        } else {
            endInput.removeAttribute('min');
        }
        validateTimes();
    });

    endInput.addEventListener('change', validateTimes);
    endInput.addEventListener('input', validateTimes);

    // run once on load to enforce when editing (reschedule)
    document.addEventListener('DOMContentLoaded', function() {
        // if start has value set min on end
        if (startInput.value) {
            endInput.min = startInput.value;
        }
        validateTimes();
    });
})();
</script>

<?= $this->endSection() ?>
