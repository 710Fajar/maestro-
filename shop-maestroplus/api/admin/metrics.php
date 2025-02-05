<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

// Check admin authentication
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Get total products
    $stmt = $conn->query("SELECT COUNT(*) FROM products");
    $totalProducts = $stmt->fetchColumn();
    
    // Get active orders
    $stmt = $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'");
    $activeOrders = $stmt->fetchColumn();
    
    // Get total users
    $stmt = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
    $totalUsers = $stmt->fetchColumn();
    
    // Get total revenue
    $stmt = $conn->query("SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE status = 'completed'");
    $totalRevenue = $stmt->fetchColumn();
    
    // Get revenue chart data (last 7 days)
    $stmt = $conn->query("
        SELECT DATE(created_at) as date, SUM(total_amount) as revenue
        FROM orders
        WHERE status = 'completed'
        AND created_at >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
        GROUP BY DATE(created_at)
        ORDER BY date ASC
    ");
    $revenueChart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get order chart data (last 7 days)
    $stmt = $conn->query("
        SELECT DATE(created_at) as date, COUNT(*) as orders
        FROM orders
        WHERE created_at >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
        GROUP BY DATE(created_at)
        ORDER BY date ASC
    ");
    $orderChart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'success',
        'metrics' => [
            'totalProducts' => $totalProducts,
            'activeOrders' => $activeOrders,
            'totalUsers' => $totalUsers,
            'totalRevenue' => $totalRevenue,
            'revenueChart' => $revenueChart,
            'orderChart' => $orderChart
        ]
    ]);
} catch(PDOException $e) {
    error_log('Admin metrics error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch metrics'
    ]);
} 