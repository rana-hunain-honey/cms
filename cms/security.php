<?php
session_start();
// Demo agent data (replace with real DB logic)
$agent_name = $_SESSION['agent_name'] ?? 'Agent Haris';

// Demo password update logic (beginner level, no DB)
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    // Demo: Assume current password is "password123"
    if ($current !== '1234@') {
        $error = 'Current password is incorrect.';
    } elseif (strlen($new) < 6) {
        $error = 'New password must be at least 6 characters.';
    } elseif ($new !== $confirm) {
        $error = 'New passwords do not match.';
    } else {
        $success = 'Password updated successfully (demo only).';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agent Security | QUICK Deliver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .security-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 40px 0 30px 0;
            margin: 60px auto 40px auto;
            max-width: 500px;
        }
        .security-icon {
            background: #e3f0ff;
            border-radius: 50%;
            padding: 18px;
            display: inline-block;
            margin-bottom: 18px;
        }
        .footer {
            background: #0d6efd;
            color: #fff;
            padding: 32px 0 0 0;
            margin-top: 40px;
        }
        .form-label {
            font-weight: 500;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
        }
    </style>
</head>
<body>
    <div class="security-section animate__animated animate__fadeInDown">
        <div class="container">
            <div class="text-center">
                <span class="security-icon"><i class="bi bi-shield-lock fs-1 text-primary"></i></span>
                <h2 class="fw-bold text-primary mb-2">Security Settings</h2>
                <div class="mb-4 text-muted" style="font-size:1.08rem;">
                    Manage your password and keep your account secure.
                </div>
            </div>
            <div class="mb-4 text-center">
                <span class="fw-semibold">Agent:</span> <?php echo htmlspecialchars($agent_name); ?>
            </div>
            <?php if ($success): ?>
                <div class="alert alert-success animate__animated animate__fadeIn mb-3"><?php echo $success; ?></div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger animate__animated animate__shakeX mb-3"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post" action="" class="px-3">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control form-control-lg" id="current_password" name="current_password" placeholder="Enter current password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" placeholder="Enter new password" required>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm"><i class="bi bi-shield-lock"></i> Update Password</button>
            </form>
            <div class="mt-4 text-center">
                <a href="admin.php" class="btn btn-outline-primary px-4"><i class="bi bi-arrow-left"></i> Back to Panel</a>
            </div>
        </div>
    </div>

    <footer class="footer animate__animated animate__fadeInUp">
        <div class="container">
            <div class="row align-items-center pb-3">
                <div class="col-md-4 mb-3 mb-md-0 text-center text-md-start">
                    <img src="images/logo1.jpg" alt="Quick Deliver Logo" width="50" height="50" class="rounded-circle mb-2">
                    <div class="fw-bold fs-5">QUICK Deliver</div>
                    <div style="font-size: 0.95rem;">Fast, Reliable & Secure Delivery</div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0 text-center">
                    <div class="mb-2 fw-semibold">Quick Links</div>
                    <a href="index.php" class="text-white text-decoration-none me-3">Home</a>
                    <a href="about.php" class="text-white text-decoration-none me-3">About</a>
                    <a href="contact.php" class="text-white text-decoration-none me-3">Contact</a>
                    <a href="tracking.php" class="text-white text-decoration-none">Tracking</a>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <div class="mb-2 fw-semibold">Contact</div>
                    <div style="font-size: 0.95rem;">
                        <i class="bi bi-envelope-fill me-1"></i> support@quickdeliver.com<br>
                        <i class="bi bi-telephone-fill me-1"></i> +1 234 567 8901
                    </div>
                    <div class="mt-2">
                        <a href="#" class="text-white me-2"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.15);">
            <div class="text-center pb-2" style="font-size: 0.97rem;">
                &copy; <?php echo date("Y"); ?> QUICK Deliver. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>