<?php
require_once '../includes/db.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

// Check authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Authentication required'
    ]);
    exit;
}

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        try {
            // Get single order if ID is provided
            if (isset($_GET['id'])) {
                $stmt = $conn->prepare("
                    SELECT o.*, oi.*, p.name as product_name, p.image_url 
                    FROM orders o
                    JOIN order_items oi ON o.id = oi.order_id
                    JOIN products p ON oi.product_id = p.id
                    WHERE o.id = ? AND o.user_id = ?
                ");
                $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
                $order = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($order) {
                    echo json_encode([
                        'status' => 'success',
                        'data' => $order
                    ]);
                } else {
                    http_response_code(404);
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Order not found'
                    ]);
                }
            } else {
                // Get all orders for user
                $stmt = $conn->prepare("
                    SELECT * FROM orders 
                    WHERE user_id = ? 
                    ORDER BY created_at DESC
                ");
                $stmt->execute([$_SESSION['user_id']]);
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode([
                    'status' => 'success',
                    'data' => $orders
                ]);
            }
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Server error'
            ]);
        }
        break;

    case 'POST':
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Start transaction
            $conn->beginTransaction();

            // Create order
            $stmt = $conn->prepare("
                INSERT INTO orders (user_id, total_amount, shipping_address, status) 
                VALUES (?, ?, ?, 'pending')
            ");
            $stmt->execute([
                $_SESSION['user_id'],
                $data['total_amount'],
                $data['shipping_address']
            ]);
            
            $orderId = $conn->lastInsertId();

            // Insert order items
            $stmt = $conn->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price) 
                VALUES (?, ?, ?, ?)
            ");

            foreach ($data['items'] as $item) {
                $stmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['quantity'],
                    $item['price']
                ]);

                // Update product stock
                $conn->prepare("
                    UPDATE products 
                    SET stock = stock - ? 
                    WHERE id = ?
                ")->execute([$item['quantity'], $item['product_id']]);
            }

            $conn->commit();

            echo json_encode([
                'status' => 'success',
                'message' => 'Order created successfully',
                'order_id' => $orderId
            ]);
        } catch(PDOException $e) {
            $conn->rollBack();
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Server error'
            ]);
        }
        break;

    case 'PUT':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Order ID required'
            ]);
            break;
        }

        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Only admin can update order status
            if ($_SESSION['user_role'] !== 'admin') {
                http_response_code(403);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ]);
                break;
            }

            $stmt = $conn->prepare("
                UPDATE orders 
                SET status = ? 
                WHERE id = ?
            ");
            $stmt->execute([$data['status'], $_GET['id']]);

            echo json_encode([
                'status' => 'success',
                'message' => 'Order updated successfully'
            ]);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Server error'
            ]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            'status' => 'error',
            'message' => 'Method not allowed'
        ]);
}
