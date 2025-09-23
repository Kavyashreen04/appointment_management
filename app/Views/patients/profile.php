<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<div class="container my-4">
    <!-- Patient Basic Info -->
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <!-- Profile Image -->
            <img src="https://via.placeholder.com/100" class="rounded-circle me-4" alt="Profile Picture">
            <div>
                <h3 class="card-title mb-1"><?= esc($patient['name']) ?></h3>
                <p class="mb-0"><strong>Gender:</strong> <?= esc($patient['gender']) ?></p>
                <p class="mb-0"><strong>Problem:</strong> <?= esc($patient['problem_description']) ?></p>
            </div>
        </div>
    </div>

    <!-- Visit History Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Visit History</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($visits)): ?>
                <div class="accordion" id="visitHistory">
                    <?php foreach ($visits as $index => $visit): ?>
                        <div class="accordion-item mb-2">
                            <h2 class="accordion-header" id="heading<?= $index ?>">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse<?= $index ?>"
                                        aria-expanded="false"
                                        aria-controls="collapse<?= $index ?>">
                                    <?= date('d M Y', strtotime($visit['visit_date'])) ?> — 
                                    Dr. <?= esc($visit['doctor_name']) ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $index ?>" class="accordion-collapse collapse"
                                 aria-labelledby="heading<?= $index ?>" data-bs-parent="#visitHistory">
                                <div class="accordion-body">
                                    <p><strong>Reason:</strong> <?= esc($visit['reason']) ?></p>
                                    <p><strong>Weight:</strong> <?= esc($visit['weight']) ?> kg</p>
                                    <p><strong>Blood Pressure:</strong> <?= esc($visit['blood_pressure']) ?></p>
                                    <p><strong>Doctor's Comments:</strong> <?= esc($visit['doctor_comments']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted text-center">No visit history available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Graph Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Health Trends</h5>
        </div>
        <div class="card-body">
            <canvas id="weightChart" class="mb-4"></canvas>
            <canvas id="bpChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const visits = <?= json_encode($visits) ?>;

    const labels = visits.map(v => new Date(v.visit_date).toLocaleDateString());
    const weights = visits.map(v => parseFloat(v.weight));
    const bp = visits.map(v => v.blood_pressure);

    // Split BP into systolic/diastolic (assuming format "120/80")
    const systolic = bp.map(b => b ? parseInt(b.split('/')[0]) : null);
    const diastolic = bp.map(b => b ? parseInt(b.split('/')[1]) : null);

    // Weight Chart
    new Chart(document.getElementById('weightChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Weight (kg)',
                data: weights,
                fill: false,
                borderColor: '#007bff',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } }
        }
    });

    // Blood Pressure Chart
    new Chart(document.getElementById('bpChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Systolic',
                    data: systolic,
                    fill: false,
                    borderColor: '#dc3545',
                    tension: 0.3
                },
                {
                    label: 'Diastolic',
                    data: diastolic,
                    fill: false,
                    borderColor: '#28a745',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } }
        }
    });
</script>

<?= $this->endSection() ?>
