<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Appointment Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6c5ce7, #00b894);
            font-family: 'Segoe UI', sans-serif;
        }

        .register-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .register-card h2 {
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        .form-control {
            border-radius: 50px;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            background-color: #00b894;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-register:hover {
            opacity: 0.9;
        }

        .text-center a {
            color: #6c5ce7;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .alert {
            font-size: 0.9rem;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="register-card">
    <h2>Register</h2>

    <!-- Display errors -->
    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/register') ?>" method="post">
        <?= csrf_field() ?>
        <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?= old('name') ?>" required>
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= old('email') ?>" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
        <button type="submit" class="btn btn-register">Register</button>
    </form>

    <div class="text-center mt-3">
        Already have an account? <a href="<?= base_url('/login') ?>">Login</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
