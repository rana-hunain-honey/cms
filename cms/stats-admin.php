<?php
// Demo stats data (replace with database logic in production)
$totalDeliveries = 120;
$activeDeliveries = 34;
$completedDeliveries = 86;
$totalAgents = 5;
$monthlyGrowth = 58; // percent
$topAgent = 'Rana Hunain';
$topAgentDeliveries = 28;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistics | QUICK Deliver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .stats-section {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 40px 0 30px 0;
            margin: 60px auto 40px auto;
            max-width: 1100px;
        }
        .stat-card {
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(13,110,253,0.07);
            transition: box-shadow 0.2s;
            background: #f3f8fd;
        }
        .stat-card:hover {
            box-shadow: 0 4px 24px rgba(13,110,253,0.13);
        }
        .stat-icon {
            font-size: 2.5rem;
            color: #0d6efd;
        }
        .stat-value {
            font-size: 2.2rem;
            font-weight: bold;
        }
        .stat-label {
            font-size: 1.1rem;
            color: #888;
        }
        .growth-badge {
            font-size: 1rem;
            padding: 0.4em 1em;
            border-radius: 12px;
        }
        @media (max-width: 767.98px) {
            .stats-section {
                padding: 18px 0 10px 0;
                margin: 24px auto 18px auto;
            }
        }
    </style>
</head>
<body>
    <div class="stats-section animate__animated animate__fadeInDown">
        <div class="container">
            <div class="d-flex align-items-center mb-4">
                <img src="images/logo1.jpg" alt="Logo" width="48" height="48" class="rounded-circle me-3">
                <div>
                    <h2 class="mb-0 text-primary fw-bold">Statistics & Reports</h2>
                    <div class="text-muted" style="font-size:1.02rem;">Delivery performance and agent analytics</div>
                </div>
                <a href="admin.php" class="btn btn-primary ms-auto me-2"><i class="bi bi-arrow-left"></i> Back To Dashboard</a>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-3 animate__animated animate__fadeInUp">
                    <div class="card stat-card text-center p-4">
                        <i class="bi bi-truck stat-icon mb-2"></i>
                        <div class="stat-value text-primary"><?php echo $totalDeliveries; ?></div>
                        <div class="stat-label">Total Deliveries</div>
                    </div>
                </div>
                <div class="col-12 col-md-3 animate__animated animate__fadeInUp" style="animation-delay:0.2s;">
                    <div class="card stat-card text-center p-4">
                        <i class="bi bi-graph-up-arrow stat-icon mb-2"></i>
                        <div class="stat-value text-success"><?php echo $activeDeliveries; ?></div>
                        <div class="stat-label">Active Deliveries</div>
                    </div>
                </div>
                <div class="col-12 col-md-3 animate__animated animate__fadeInUp" style="animation-delay:0.4s;">
                    <div class="card stat-card text-center p-4">
                        <i class="bi bi-check2-circle stat-icon mb-2"></i>
                        <div class="stat-value text-info"><?php echo $completedDeliveries; ?></div>
                        <div class="stat-label">Completed Deliveries</div>
                    </div>
                </div>
                <div class="col-12 col-md-3 animate__animated animate__fadeInUp" style="animation-delay:0.6s;">
                    <div class="card stat-card text-center p-4">
                        <i class="bi bi-people stat-icon mb-2"></i>
                        <div class="stat-value text-warning"><?php echo $totalAgents; ?></div>
                        <div class="stat-label">Total Agents</div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 animate__animated animate__fadeInUp">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-bar-chart-line me-2"></i> Monthly Growth</h5>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success growth-badge"><i class="bi bi-arrow-up-right me-1"></i> <?php echo $monthlyGrowth; ?>% Growth</span>
                                <span class="ms-3 text-muted">Compared to last month</span>
                            </div>
                            <div class="progress" style="height: 18px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $monthlyGrowth; ?>%;" aria-valuenow="<?php echo $monthlyGrowth; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 animate__animated animate__fadeInUp" style="animation-delay:0.2s;">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-trophy me-2"></i> Top Agent</h5>
                            <div class="d-flex align-items-center mb-2">
                                <img src="images/agent.jpg" alt="Top Agent" class="rounded-circle me-3" width="48" height="48">
                                <div>
                                    <div class="fw-bold text-dark"><?php echo $topAgent; ?></div>
                                    <div class="text-muted">Deliveries: <?php echo $topAgentDeliveries; ?></div>
                                </div>
                            </div>
                            <span class="badge bg-primary">Top Performer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
