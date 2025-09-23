<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    body { font-family: 'Poppins', sans-serif; margin:0; padding:0; scroll-behavior: smooth; }
    .navbar { padding: 1rem 2rem; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .navbar-brand { font-weight: 700; color: #6c5ce7; font-size: 1.6rem; }
    .nav-link { font-weight: 600; color: #555; margin-left: 15px; transition: 0.3s; }
    .nav-link:hover { color: #6c5ce7; }
    .btn-landing { border-radius: 50px; padding: 10px 25px; font-weight: 600; }
    .btn-success { background-color: #00b894; border-color: #00b894; color: #fff; }
    .btn-light { background-color: #fff; color: #6c5ce7; border: 2px solid #fff; }
    .hero { background: linear-gradient(135deg,#6c5ce7,#00b894); color:#fff; min-height:90vh; display:flex; align-items:center; padding:0 5%; }
    .hero h1 { font-size:3rem; font-weight:700; line-height:1.2; }
    .hero p { font-size:1.2rem; margin:20px 0 40px; }
    .hero-img img { max-width:500px; animation: float 4s ease-in-out infinite; }
    @keyframes float {0%,100%{transform:translateY(0);}50%{transform:translateY(-15px);}}
    .features { padding:80px 5%; background:#f9f9f9; text-align:center; }
    .feature-card { border-radius:15px; padding:40px 20px; background:#fff; box-shadow:0 10px 25px rgba(0,0,0,0.1); transition:0.3s; }
    .feature-card:hover { transform:translateY(-10px); }
    .feature-card h4 { font-weight:600; margin-bottom:15px; color:#6c5ce7; }
    .feature-card p { font-size:0.95rem; color:#555; }
    .testimonials { padding:80px 5%; background:#fff; text-align:center; }
    .testimonial-card { border-radius:15px; padding:30px; background:#f1f5ff; box-shadow:0 10px 25px rgba(0,0,0,0.1); margin-bottom:30px; transition:0.3s; }
    .testimonial-card:hover { transform:translateY(-5px); }
    .testimonial-card p { font-style:italic; color:#555; }
    .testimonial-card h5 { font-weight:600; margin-top:15px; color:#6c5ce7; }
    footer { background:#222; color:#fff; padding:20px 0; text-align:center; }
    @media(max-width:991px){ .hero { flex-direction:column; text-align:center; } .hero-img { margin-top:30px; } .hero h1{font-size:2.5rem;} }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="<?= base_url('/') ?>">Appointment Portal</a>
    <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="<?= base_url('/login') ?>">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= base_url('/register') ?>">Register</a></li>
        </ul>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero d-flex justify-content-between align-items-center container-fluid">
    <div class="content">
        <h1>Effortless Appointment Management</h1>
        <p>Book, reschedule, or cancel appointments. Manage doctors and patients seamlessly in one place.</p>
        <a href="<?= base_url('/login') ?>" class="btn btn-light btn-landing me-2">Login</a>
        <a href="<?= base_url('/register') ?>" class="btn btn-success btn-landing">Register</a>
    </div>
    <div class="hero-img">
        <img src="https://undraw.co/api/illustrations/doctor_appointment.svg" alt="Doctor Appointment">
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <h2 class="mb-5">Why Choose Appointment Portal</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-speedometer2 fs-1 text-primary mb-3"></i>
                <h4>Fast & Reliable</h4>
                <p>Manage appointments and patients quickly with a modern, responsive interface.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-shield-check fs-1 text-success mb-3"></i>
                <h4>Secure Data</h4>
                <p>All patient and appointment information is securely stored and encrypted.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-calendar-check fs-1 text-warning mb-3"></i>
                <h4>Conflict-Free Scheduling</h4>
                <p>Prevents overlapping appointments for smooth management.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <h2 class="mb-5">What Our Users Say</h2>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="testimonial-card">
                <p>"This portal made scheduling appointments extremely easy. Highly recommended!"</p>
                <h5>- Dr. Smith</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
                <p>"Managing all patients and appointments without stress. Amazing system."</p>
                <h5>- Nurse Kelly</h5>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    &copy; <?= date('Y') ?> Appointment Portal. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
