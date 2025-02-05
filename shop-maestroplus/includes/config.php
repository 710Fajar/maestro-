<?php
// Tambahkan di awal file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'maestroplus_db');

// Application configuration
define('BASE_URL', 'http://localhost/shop-maestroplus');
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/shop-maestroplus/assets/images/');
define('ASSETS_URL', '/assets/images/');
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Tambahkan konstanta untuk session
define('SESSION_LIFETIME', 86400); // 24 jam
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
session_set_cookie_params(SESSION_LIFETIME);