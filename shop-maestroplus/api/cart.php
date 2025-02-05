<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login to view cart',
        'code' => 'AUTH_REQUIRED'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Validasi input untuk POST/PUT
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request data',
            'code' => 'INVALID_DATA'
        ]);
        exit;
    }
}

try {
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Get cart items
            $stmt = $conn->prepare("
                SELECT c.*, p.name, p.price, p.image_url 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'status' => 'success',
                'data' => $items
            ]);
            break;

        case 'POST':
            // Add to cart
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Check if product already in cart
            $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$_SESSION['user_id'], $data['product_id']]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                // Update quantity
                $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ?");
                $stmt->execute([$existing['id']]);
            } else {
                // Insert new item
                $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
                $stmt->execute([$_SESSION['user_id'], $data['product_id']]);
            }
            
            echo json_encode(['status' => 'success']);
            break;

        case 'PUT':
            // Update cart item quantity
            $data = json_decode(file_get_contents('php://input'), true);
            
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$data['quantity'], $data['cart_id'], $_SESSION['user_id']]);
            
            echo json_encode(['status' => 'success']);
            break;

        case 'DELETE':
            // Remove from cart
            $cart_id = $_GET['id'] ?? null;
            
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $stmt->execute([$cart_id, $_SESSION['user_id']]);
            
            echo json_encode(['status' => 'success']);
            break;
    }
} catch(PDOException $e) {
    error_log('Cart error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'An error occurred while processing your request'
    ]);
} 