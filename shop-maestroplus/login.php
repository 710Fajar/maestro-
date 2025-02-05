<?php
require_once 'includes/config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . (($_SESSION['user_role'] === 'admin') ? '/admin' : ''));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MAESTROPLUS+</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Login</h2>
                <p>Welcome back! Please login to your account.</p>
            </div>
            <form id="login-form" class="auth-form">
                <div class="form-group">
                    <input type="email" id="email" required placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" id="password" required placeholder="Password">
                </div>
                <button type="submit" class="auth-button">Login</button>
            </form>
        </div>
    </div>

    <script>
        const BASE_URL = '<?= BASE_URL ?>';
        
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            try {
                const response = await fetch(`${BASE_URL}/api/auth.php?action=login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    window.location.href = BASE_URL + ((data.user.role === 'admin') ? '/admin' : '');
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Login failed. Please try again.');
            }
        });
    </script>
</body>
</html> 