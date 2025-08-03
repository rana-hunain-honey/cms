<?php
include('dbconnect.php');
$deliveries = [];
$sql = "SELECT p.consignment_no, p.sender_name, p.receiver_name, p.to_city, p.status, p.created_at as booking_date FROM packages p ORDER BY p.created_at DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $deliveries[] = [
            'id' => $row['consignment_no'],
            'customer' => $row['receiver_name'] ?: 'N/A',
            'address' => $row['to_city'] ?: 'N/A',
            'status' => $row['status'],
            'date' => $row['booking_date']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show Deliveries | QUICK Deliver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .delivery-section {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 40px 0 30px 0;
            margin: 60px auto 40px auto;
            max-width: 1100px;
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
        @media (max-width: 767.98px) {
            .delivery-section {
                padding: 18px 0 10px 0;
                margin: 24px auto 18px auto;
            }
        }
    </style>
</head>
<body>
    <div class="delivery-section animate__animated animate__fadeInDown">
        <div class="container">
            <div class="d-flex align-items-center mb-4">
                <img src="images/logo1.jpg" alt="Logo" width="48" height="48" class="rounded-circle me-3">
                <div>
                    <h2 class="mb-0 text-primary fw-bold">Deliveries</h2>
                    <div class="text-muted" style="font-size:1.02rem;">Recent and ongoing deliveries</div>
                </div>
                <a href="admin.php" class="btn btn-primary ms-auto me-2"><i class="bi bi-arrow-left"></i> Back To Dashboard</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-middle shadow-sm">
                    <thead>
                        <tr>
                            <th scope="col"><i class="bi bi-hash"></i> Delivery ID</th>
                            <th scope="col"><i class="bi bi-person"></i> Customer</th>
                            <th scope="col"><i class="bi bi-geo-alt"></i> Address</th>
                            <th scope="col"><i class="bi bi-calendar"></i> Date</th>
                            <th scope="col"><i class="bi bi-truck"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deliveries as $delivery): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($delivery['id']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['customer']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['address']); ?></td>
                            <td><?php echo htmlspecialchars($delivery['date']); ?></td>
                            <td>
                                <?php if ($delivery['status'] === 'Delivered'): ?>
                                    <span class="badge bg-success status-badge">Delivered</span>
                                <?php elseif ($delivery['status'] === 'In Transit'): ?>
                                    <span class="badge bg-warning text-dark status-badge">In Transit</span>
                                <?php elseif ($delivery['status'] === 'Out for Delivery'): ?>
                                    <span class="badge bg-info text-white status-badge">Out for Delivery</span>
                                <?php elseif ($delivery['status'] === 'Cancelled'): ?>
                                    <span class="badge bg-danger status-badge">Cancelled</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary status-badge"><?php echo htmlspecialchars($delivery['status']); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($deliveries)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No deliveries found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
