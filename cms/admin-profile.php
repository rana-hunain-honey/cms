<?php
session_start();
include('dbconnect.php');
require_once 'rate_limiter.php';

// Session timeout (3 hours)
$session_timeout = 3 * 60 * 60; // 3 hours in seconds

// Check if admin logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit();
}

// Check session timeout
if (isset($_SESSION['admin_login_time']) && (time() - $_SESSION['admin_login_time']) > $session_timeout) {
    session_destroy();
    header('Location: admin-login.php?timeout=1');
    exit();
}

// Validate session IP (basic session hijacking protection)
if (isset($_SESSION['admin_ip']) && $_SESSION['admin_ip'] !== getUserIP()) {
    session_destroy();
    header('Location: admin-login.php?security=1');
    exit();
}

// Update last activity time
$_SESSION['admin_login_time'] = time();

$admin = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'role' => '',
    'status' => '',
    'joined' => '',
    'avatar' => 'images/adminlogo.jpg'
];

// Get admin ID from session (you may need to adjust this based on your session structure)
$admin_id = $_SESSION['admin_id'] ?? 1; // Default to 1 if not set

$sql = "SELECT * FROM admins WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $admin['name'] = htmlspecialchars($row['name']);
    $admin['email'] = htmlspecialchars($row['email']);
    $admin['phone'] = htmlspecialchars($row['phone'] ?? 'Not Available');
    $admin['role'] = $row['role'];
    $admin['status'] = $row['status'];
    $admin['joined'] = $row['created_at'];
    
    // Get some statistics
    $total_agents = $conn->query("SELECT COUNT(*) as cnt FROM agents")->fetch_assoc()['cnt'] ?? 0;
    $total_packages = $conn->query("SELECT COUNT(*) as cnt FROM packages")->fetch_assoc()['cnt'] ?? 0;
    $total_users = $conn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc()['cnt'] ?? 0;
} else {
    header('Location: admin-login.php');
    exit();
}
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile | QUICK Deliver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .profile-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 40px 0 30px 0;
            margin: 60px auto 40px auto;
            max-width: 600px;
        }
        .profile-avatar {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #0d6efd;
            margin-bottom: 18px;
        }
        .status-badge {
            font-size: 0.95rem;
            padding: 0.35em 0.9em;
            border-radius: 12px;
        }
        .role-badge {
            font-size: 0.9rem;
            padding: 0.3em 0.8em;
            border-radius: 10px;
        }
        .stats-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 10px;
            text-align: center;
            border: 1px solid #e9ecef;
        }
        @media (max-width: 767.98px) {
            .profile-section {
                margin: 30px auto 20px auto;
                padding: 30px 15px 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="profile-section text-center animate__animated animate__fadeInDown">
        <div class="container">
            <img src="<?php echo $admin['avatar']; ?>" alt="Admin Avatar" class="profile-avatar shadow">
            <h2 class="fw-bold text-primary mb-1"><?php echo htmlspecialchars($admin['name']); ?></h2>
            <div class="mb-3">
                <?php if ($admin['role'] === 'Super Admin'): ?>
                    <span class="badge bg-danger role-badge me-2">Super Admin</span>
                <?php else: ?>
                    <span class="badge bg-primary role-badge me-2">Admin</span>
                <?php endif; ?>
                <?php if ($admin['status'] === 'Active'): ?>
                    <span class="badge bg-success status-badge">Active</span>
                <?php else: ?>
                    <span class="badge bg-secondary status-badge">Inactive</span>
                <?php endif; ?>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-envelope-fill text-primary me-2"></i>
                        <span class="fw-semibold"><?php echo htmlspecialchars($admin['email']); ?></span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-telephone-fill text-primary me-2"></i>
                        <span class="fw-semibold"><?php echo htmlspecialchars($admin['phone']); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <i class="bi bi-calendar-check text-primary me-2"></i>
                <span class="fw-semibold">Joined: <?php echo date('F j, Y', strtotime($admin['joined'])); ?></span>
            </div>

            <!-- Admin Statistics -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <i class="bi bi-people fs-2 text-primary mb-2"></i>
                        <h5 class="fw-bold mb-1">Total Agents</h5>
                        <div class="fs-4 fw-bold text-success"><?php echo $total_agents; ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <i class="bi bi-box fs-2 text-primary mb-2"></i>
                        <h5 class="fw-bold mb-1">Total Packages</h5>
                        <div class="fs-4 fw-bold text-warning"><?php echo $total_packages; ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <i class="bi bi-person-lines-fill fs-2 text-primary mb-2"></i>
                        <h5 class="fw-bold mb-1">Total Users</h5>
                        <div class="fs-4 fw-bold text-info"><?php echo $total_users; ?></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="admin.php" class="btn btn-outline-primary px-4"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
                <a href="feedback-admin.php" class="btn btn-outline-info px-4"><i class="bi bi-chat-dots"></i> View Feedbacks</a>
                <a href="admin-logout.php" class="btn btn-danger px-4"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>