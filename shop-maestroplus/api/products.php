<?php
require_once '../includes/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: ' . BASE_URL);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$db = new Database();
$conn = $db->getConnection();

// Handle OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        try {
            $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Format price and add image URL
            foreach ($products as &$product) {
                $product['image_url'] = $product['image_url'] 
                    ? BASE_URL . '/assets/images/' . basename($product['image_url'])
                    : BASE_URL . '/assets/images/placeholder.jpg';
                $product['price'] = (float)$product['price'];
            }
            
            echo json_encode([
                'status' => 'success',
                'data' => $products
            ]);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error'
            ]);
        }
        break;
        
    case 'POST':
        // Check authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            exit;
        }

        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validate required fields
            $required = ['name', 'description', 'price', 'stock', 'category'];
            foreach ($required as $field) {
                if (!isset($data[$field])) {
                    throw new Exception("Missing required field: $field");
                }
            }

            $stmt = $conn->prepare("
                INSERT INTO products (name, description, price, stock, category, image_url)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['name'],
                $data['description'],
                $data['price'],
                $data['stock'],
                $data['category'],
                $data['image_url'] ?? null
            ]);

            echo json_encode([
                'status' => 'success',
                'message' => 'Product created successfully',
                'id' => $conn->lastInsertId()
            ]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        break;
        
    case 'PUT':
        // Handle product update
        break;
        
    case 'DELETE':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Product ID required']);
            exit;
        }

        try {
            // Get image URL before deleting
            $stmt = $conn->prepare("SELECT image_url FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch();

            // Delete from database
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);

            // Delete image file if exists
            if ($product && $product['image_url']) {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . $product['image_url'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            echo json_encode(['status' => 'success']);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
        break;
} 