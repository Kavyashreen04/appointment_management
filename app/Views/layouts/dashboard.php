<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Dashboard' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f8f9fa;
    }

    /* Sidebar */
    .sidebar {
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        width: 220px;
        background-color: #343a40;
        padding-top: 60px;
        transition: 0.3s;
    }

    .sidebar a {
        display: block;
        color: #cfd8dc;
        padding: 15px 20px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
    }

    .sidebar a:hover {
        background-color: #495057;
        color: #fff;
        border-radius: 8px;
    }

    .sidebar a.active {
        background-color: #6c5ce7;
        color: #fff;
        border-radius: 8px;
    }

    /* Main content */
    .main-content {
        margin-left: 220px;
        padding: 20px;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 2.5rem;
    }

    .table thead {
        background-color: #6c5ce7;
        color: #fff;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <a href="/dashboard" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="/doctors"><i class="bi bi-person-badge"></i> Manage Doctors</a>
    <a href="/patients"><i class="bi bi-people"></i> Manage Patients</a>
    <a href="/appointments"><i class="bi bi-calendar-check"></i> Appointments</a>
    <a href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main content -->
<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
