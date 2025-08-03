<?php
session_start();
include('dbconnect.php');

// Check if agent is logged in (basic check - you may need to adjust based on your auth system)
// For now, we'll assume agents can access this page

// Fetch feedbacks from database
$feedbacks = [];
$sql = "SELECT f.*, u.name as user_name FROM feedback f LEFT JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'] ?: 'N/A',
            'subject' => $row['subject'],
            'message' => $row['message'],
            'status' => $row['status'],
            'priority' => $row['priority'],
            'user_name' => $row['user_name'] ?: 'Guest',
            'created_at' => $row['created_at']
        //     'admin_response' => $row['admin_response'],
        //     'response_date' => $row['response_date']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Feedbacks | QUICK Deliver Agent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .feedback-section {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            padding: 40px 0 30px 0;
            margin: 60px auto 40px auto;
            max-width: 1200px;
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
            font-size: 0.85rem;
            padding: 0.25em 0.7em;
            border-radius: 10px;
        }
        .priority-badge {
            font-size: 0.8rem;
            padding: 0.2em 0.6em;
            border-radius: 8px;
        }
        .message-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .btn-sm {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        @media (max-width: 767.98px) {
            .feedback-section {
                padding: 18px 0 10px 0;
                margin: 24px auto 18px auto;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="feedback-section animate__animated animate__fadeInDown">
        <div class="container">
            <div class="d-flex align-items-center mb-4">
                <img src="images/logo1.jpg" alt="Logo" width="48" height="48" class="rounded-circle me-3">
                <div>
                    <h2 class="mb-0 text-primary fw-bold">User Feedbacks</h2>
                    <div class="text-muted" style="font-size:1.02rem;">Messages and feedback from users</div>
                </div>
                <a href="agent.php" class="btn btn-primary ms-auto me-2"><i class="bi bi-arrow-left"></i> Back To Dashboard</a>
            </div>
            
            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-chat-dots fs-3 text-primary mb-2"></i>
                            <h6 class="fw-bold mb-1">Total Feedbacks</h6>
                            <div class="fs-4 fw-bold text-success"><?php echo count($feedbacks); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-exclamation-triangle fs-3 text-warning mb-2"></i>
                            <h6 class="fw-bold mb-1">New</h6>
                            <div class="fs-4 fw-bold text-warning"><?php echo count(array_filter($feedbacks, function($f) { return $f['status'] === 'New'; })); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-clock fs-3 text-info mb-2"></i>
                            <h6 class="fw-bold mb-1">In Progress</h6>
                            <div class="fs-4 fw-bold text-info"><?php echo count(array_filter($feedbacks, function($f) { return $f['status'] === 'In Progress'; })); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle fs-3 text-success mb-2"></i>
                            <h6 class="fw-bold mb-1">Resolved</h6>
                            <div class="fs-4 fw-bold text-success"><?php echo count(array_filter($feedbacks, function($f) { return $f['status'] === 'Resolved'; })); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped align-middle shadow-sm">
                    <thead>
                        <tr>
                            <th scope="col"><i class="bi bi-hash"></i> ID</th>
                            <th scope="col"><i class="bi bi-person"></i> Name</th>
                            <th scope="col"><i class="bi bi-envelope"></i> Email</th>
                            <th scope="col"><i class="bi bi-chat-text"></i> Subject</th>
                            <th scope="col"><i class="bi bi-card-text"></i> Message</th>
                            <th scope="col"><i class="bi bi-flag"></i> Priority</th>
                            <th scope="col"><i class="bi bi-info-circle"></i> Status</th>
                            <th scope="col"><i class="bi bi-calendar"></i> Date</th>
                            <th scope="col"><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($feedback['id']); ?></td>
                            <td>
                                <div class="fw-semibold"><?php echo htmlspecialchars($feedback['name']); ?></div>
                                <small class="text-muted"><?php echo htmlspecialchars($feedback['user_name']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['subject']); ?></td>
                            <td>
                                <div class="message-preview" title="<?php echo htmlspecialchars($feedback['message']); ?>">
                                    <?php echo htmlspecialchars(substr($feedback['message'], 0, 50)) . (strlen($feedback['message']) > 50 ? '...' : ''); ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($feedback['priority'] === 'Urgent'): ?>
                                    <span class="badge bg-danger priority-badge">Urgent</span>
                                <?php elseif ($feedback['priority'] === 'High'): ?>
                                    <span class="badge bg-warning text-dark priority-badge">High</span>
                                <?php elseif ($feedback['priority'] === 'Medium'): ?>
                                    <span class="badge bg-info priority-badge">Medium</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary priority-badge">Low</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($feedback['status'] === 'New'): ?>
                                    <span class="badge bg-warning text-dark status-badge">New</span>
                                <?php elseif ($feedback['status'] === 'In Progress'): ?>
                                    <span class="badge bg-info status-badge">In Progress</span>
                                <?php elseif ($feedback['status'] === 'Resolved'): ?>
                                    <span class="badge bg-success status-badge">Resolved</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary status-badge">Closed</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($feedback['created_at'])); ?></td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm me-1" onclick="viewFeedback(<?php echo $feedback['id']; ?>)" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-outline-info btn-sm" onclick="notifyAdmin(<?php echo $feedback['id']; ?>)" title="Notify Admin">
                                    <i class="bi bi-bell"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($feedbacks)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">No feedbacks found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewFeedback(id) {
            // Placeholder for view feedback functionality
            alert('View feedback details for ID: ' + id);
        }

        function notifyAdmin(id) {
            // Placeholder for notify admin functionality
            alert('Notify admin about feedback ID: ' + id);
        }
    </script>
</body>
</html>