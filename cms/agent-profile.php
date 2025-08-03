<?php
session_start();
require_once 'dbconnect.php';
require_once 'security_config.php';
require_once 'error_logger.php';

// Check if agent is logged in
if (!isset($_SESSION['agent_logged_in']) || !isset($_SESSION['agent_id'])) {
    header('Location: agent-login.php');
    exit();
}

$agent = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'status' => '',
    'branch_city' => '',
    'joined' => '',
    'avatar' => 'images/agentlogo.jpg'
];

$agent_id = $_SESSION['agent_id'];
$sql = "SELECT * FROM agents WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $agent_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $agent['name'] = htmlspecialchars($row['name']);
    $agent['email'] = htmlspecialchars($row['email']);
    $agent['phone'] = htmlspecialchars($row['phone']);
    $agent['status'] = $row['status'];
    $agent['branch_city'] = 'Not Available'; // This field doesn't exist in current schema
    $agent['joined'] = date('Y-m-d'); // Use current date as placeholder
    $agent['total_deliveries'] = 0; // Placeholder since parcels table might not exist
} else {
    logError('Agent profile not found', 'AGENT_PROFILE_ERROR', ['agent_id' => $agent_id]);
    header('Location: agent-login.php');
    exit();
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agent Profile | QUICK Deliver</title>
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
            max-width: 500px;
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
    </style>
</head>
<body>
    <div class="profile-section text-center animate__animated animate__fadeInDown">
        <img src="<?php echo $agent['avatar']; ?>" alt="Agent Avatar" class="profile-avatar shadow">
        <h2 class="fw-bold text-primary mb-1"><?php echo htmlspecialchars($agent['name']); ?></h2>
        <div class="mb-3">
            <?php if ($agent['status'] === 'Active'): ?>
                <span class="badge bg-success status-badge">Active</span>
            <?php else: ?>
                <span class="badge bg-secondary status-badge">Inactive</span>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <i class="bi bi-envelope-fill text-primary me-2"></i>
            <span class="fw-semibold"><?php echo htmlspecialchars($agent['email']); ?></span>
        </div>
        <div class="mb-3">
            <i class="bi bi-telephone-fill text-primary me-2"></i>
            <span class="fw-semibold"><?php echo htmlspecialchars($agent['phone']); ?></span>
        </div>
        <div class="mb-3">
            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
            <span class="fw-semibold">Branch: <?php echo $agent['branch_city']; ?></span>
        </div>
        <div class="mb-3">
            <i class="bi bi-truck text-primary me-2"></i>
            <span class="fw-semibold">Total Deliveries: <?php echo $agent['total_deliveries']; ?></span>
        </div>
        <div class="mb-4">
            <i class="bi bi-calendar-check text-primary me-2"></i>
            <span class="fw-semibold">Joined: <?php echo date('F j, Y', strtotime($agent['joined'])); ?></span>
        </div>
        <a href="agent.php" class="btn btn-outline-primary px-4"><i class="bi bi-arrow-left"></i> Back to Panel</a>
        <a href="agent-logout.php" class="btn btn-danger px-4 ms-2"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

</body>
</html>