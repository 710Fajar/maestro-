<?php
require_once 'includes/config.php';

// Clear session
session_destroy();

// Clear cookies if any
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Redirect to home
header('Location: ' . BASE_URL);
exit; 