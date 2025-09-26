<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<div class="container">
    <h3 class="mb-4">Complete Appointment</h3>

    <div class="card shadow-sm p-4">
        <form method="post" action="<?= site_url('appointments/mark-completed/' . $appointment['id']) ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Patient</label>
                <input type="text" class="form-control" 
                       value="<?= esc($appointment['patient_name'] ?? '') ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Doctor</label>
                <input type="text" class="form-control" 
                       value="<?= esc($appointment['doctor_name'] ?? '') ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Weight (kg)</label>
                <input type="number" step="0.1" name="weight" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Blood Pressure</label>
                <input type="text" name="blood_pressure" class="form-control" placeholder="e.g. 120/80" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Doctor Comments</label>
                <textarea name="doctor_comments" class="form-control" rows="3" required></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save & Complete
                </button>
                <a href="<?= site_url('appointments') ?>" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
