<header>
    <nav>
        <div class="logo">MAESTROPLUS+</div>
        <ul>
            <li><a href="<?= BASE_URL ?>/#home">Home</a></li>
            <li><a href="<?= BASE_URL ?>/#products">Products</a></li>
            <li>
                <a href="<?= BASE_URL ?>/#cart">Cart <span id="cart-count" class="cart-count">0</span></a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="<?= BASE_URL ?>/account.php">My Account</a></li>
                <li><a href="<?= BASE_URL ?>/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header> 