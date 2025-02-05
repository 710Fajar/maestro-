<?php 
require_once '../includes/config.php';

// Check if admin is logged in
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/css/admin.css">
</head>
<body>
    <?php include 'admin-content.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= BASE_URL ?>/admin/js/data.js"></script>
    <script src="<?= BASE_URL ?>/admin/js/admin.js"></script>

    <!-- Di dalam dashboard section -->
    <div class="dashboard-charts">
        <div class="chart-container">
            <h3>Revenue (Last 7 Days)</h3>
            <canvas id="revenue-chart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Orders (Last 7 Days)</h3>
            <canvas id="order-chart"></canvas>
        </div>
    </div>
</body>
</html> 