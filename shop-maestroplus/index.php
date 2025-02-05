<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MAESTROPLUS+ - Your premier destination for cricket equipment">
    <title>MAESTROPLUS+ - Cricket Equipment Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/main.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">MAESTROPLUS+</div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#cart">Cart</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="<?= BASE_URL ?>/account.php">My Account</a></li>
                    <li><a href="<?= BASE_URL ?>/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Notifications Container -->
    <div id="notifications" class="notifications-container"></div>

    <!-- Main Content -->
    <main>
        <section id="home" class="section">
            <!-- Home content -->
            <div class="hero">
                <h1>Welcome to MAESTROPLUS+</h1>
                <p>Your premier destination for cricket equipment</p>
            </div>
        </section>

        <section id="products" class="section">
            <h2>Our Products</h2>
            <div id="products-container" class="products-grid">
                <!-- Products loaded here -->
            </div>
        </section>

        <section id="cart" class="section">
            <h2>Shopping Cart</h2>
            <div id="cart-container">
                <!-- Cart items loaded here -->
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MAESTROPLUS+. All rights reserved.</p>
    </footer>

    <!-- Scripts -->
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= BASE_URL ?>/js/app.js"></script>
</body>
</html> 