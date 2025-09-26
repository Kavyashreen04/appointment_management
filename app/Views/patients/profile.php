<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('content') ?>

<h2 class="mb-4"><?= esc($patient['name']) ?>'s Profile</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h5>Patient Details</h5>
            <p><strong>Name:</strong> <?= esc($patient['name']) ?></p>
             <p><strong>Age:</strong> <?= $patient['age'] ?? 'N/A' ?></p>
            <p><strong>Gender:</strong> <?= esc($patient['gender']) ?></p>
            <p><strong>Problem:</strong> <?= esc($patient['problem_description']) ?></p>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm p-3">
            <h5>Visit History</h5>
            <?php if (!empty($visits)): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Problem</th>
                            <th>Weight</th>
                            <th>Blood Pressure</th>
                            <th>Doctor</th>
                            <th>Comments</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visits as $i => $visit): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($visit['problem_description']) ?></td>
                                <td><?= esc($visit['weight']) ?></td>
                                <td><?= esc($visit['blood_pressure']) ?></td>
                                <td><?= esc($visit['doctor_name']) ?></td>
                                <td><?= esc($visit['doctor_comments']) ?></td>

                                <td><?= date('d M Y H:i', strtotime($visit['visit_datetime'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No visits recorded yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!empty($visits)): ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Weight Trend</h5>
                <canvas id="weightChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Blood Pressure Trend</h5>
                <canvas id="bpChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const visits = <?= json_encode($visits) ?>;

        const labels = visits.map(v => new Date(v.visit_datetime).toLocaleDateString());
        const weights = visits.map(v => parseFloat(v.weight) || null);
        const bpValues = visits.map(v => v.blood_pressure ? v.blood_pressure.split('/').map(Number) : [null, null]);

        // Weight Chart
        const ctxWeight = document.getElementById('weightChart').getContext('2d');
        new Chart(ctxWeight, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Weight (kg)',
                    data: weights,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true,
                    spanGaps: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // Blood Pressure Chart
        const ctxBP = document.getElementById('bpChart').getContext('2d');
        new Chart(ctxBP, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Systolic (mmHg)',
                        data: bpValues.map(v => v[0]),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3,
                        fill: false,
                        spanGaps: true
                    },
                    {
                        label: 'Diastolic (mmHg)',
                        data: bpValues.map(v => v[1]),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.3,
                        fill: false,
                        spanGaps: true
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>