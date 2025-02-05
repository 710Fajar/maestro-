<?php
require_once '../includes/db.php';
require_once '../includes/config.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        switch($action) {
            case 'login':
                try {
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND status = 'active' LIMIT 1");
                    $stmt->execute([$data['email']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user && password_verify($data['password'], $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_role'] = $user['role'];
                        $_SESSION['user_name'] = $user['name'];
                        
                        echo json_encode([
                            'status' => 'success',
                            'user' => [
                                'id' => $user['id'],
                                'name' => $user['name'],
                                'email' => $user['email'],
                                'role' => $user['role']
                            ]
                        ]);
                    } else {
                        http_response_code(401);
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Invalid credentials'
                        ]);
                    }
                } catch(PDOException $e) {
                    http_response_code(500);
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Database error'
                    ]);
                }
                break;

            case 'register':
                try {
                    $name = $data['name'];
                    $email = $data['email'];
                    $password = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Check if email exists
                    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        http_response_code(400);
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Email already exists'
                        ]);
                        break;
                    }

                    // Insert new user
                    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                    $stmt->execute([$name, $email, $password]);

                    $userId = $conn->lastInsertId();
                    
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Registration successful',
                        'user_id' => $userId
                    ]);
                } catch(PDOException $e) {
                    http_response_code(500);
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Server error'
                    ]);
                }
                break;

            case 'logout':
                session_destroy();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Logged out successfully'
                ]);
                break;

            default:
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid action'
                ]);
        }
        break;

    case 'GET':
        if (isset($_SESSION['user_id'])) {
            try {
                $stmt = $conn->prepare("SELECT id, name, email, role, status FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                echo json_encode([
                    'status' => 'success',
                    'user' => $user
                ]);
            } catch(PDOException $e) {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Server error'
                ]);
            }
        } else {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Not authenticated'
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
