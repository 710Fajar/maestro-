<?php
require_once 'includes/config.php';

// Redirect jika tidak login
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

// Get user data
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - MAESTROPLUS+</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/main.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <section class="account-section">
            <h2>My Account</h2>
            <div class="account-details">
                <h3>Profile Information</h3>
                <form id="profile-form" class="profile-form">
                    <!-- Profile form fields -->
                </form>
            </div>
            
            <div class="order-history">
                <h3>Order History</h3>
                <div id="orders-container">
                    <!-- Orders loaded here -->
                </div>
            </div>
        </section>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= BASE_URL ?>/js/app.js"></script>
</body>
</html> 