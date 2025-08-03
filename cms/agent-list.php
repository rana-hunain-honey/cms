<?php
include('dbconnect.php');
$agents = [];
$sql = "SELECT * FROM agents ORDER BY id ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $agents[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agent List | QUICK Deliver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .agent-list-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 40px 0 30px 0;
            margin: 60px auto 40px auto;
            max-width: 1000px;
        }
        .table thead th {
            background: #0d6efd;
            color: #fff;
            border: none;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f3f8fd;
        }
        .status-badge {
            font-size: 0.95rem;
            padding: 0.35em 0.9em;
            border-radius: 12px;
        }
        .footer {
            background: #0d6efd;
            color: #fff;
            padding: 32px 0 0 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="agent-list-section animate__animated animate__fadeInDown">
        <div class="container">
            <div class="d-flex align-items-center mb-4">
                <img src="images/logo1.jpg" alt="Logo" width="48" height="48" class="rounded-circle me-3">
                <div>
                    <h2 class="mb-0 text-primary fw-bold">Agent List</h2>
                    <div class="text-muted" style="font-size:1.02rem;">All registered delivery agents</div>
                </div>
                <a href="agent.php" class="btn btn-primary ms-auto me-2"><i class="bi bi-arrow-left"></i> Back To Agent Pannel</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-middle shadow-sm">
                    <thead>
                        <tr>
                            <th scope="col"><i class="bi bi-person"></i> Name</th>
                            <th scope="col"><i class="bi bi-envelope"></i> Email</th>
                            <th scope="col"><i class="bi bi-telephone"></i> Phone</th>
                            <th scope="col"><i class="bi bi-check-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agents as $agent): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($agent['name']); ?></td>
                            <td><?php echo htmlspecialchars($agent['email']); ?></td>
                            <td><?php echo htmlspecialchars($agent['phone']); ?></td>
                            <td>
                                <?php if ($agent['status'] === 'Active'): ?>
                                    <span class="badge bg-success status-badge">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary status-badge">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($agents)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No agents found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

