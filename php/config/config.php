<?php
// =====================================================
// Konfigurasi koneksi database (XAMPP default)
// =====================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_db');

// Root folder /php/
define('PHP_ROOT', dirname(__DIR__));

// Folder penyimpanan gambar: /portfolio/php/img/
define('UPLOAD_DIR', PHP_ROOT . '/img/');

// URL prefix <img src="..."> sesuai lokasi pemanggil:
// - dari /php/*.php          (index.php, login.php) → img/
// - dari /php/admin/*.php    & /php/crud/*.php       → ../img/
define('IMG_URL_PUBLIC', 'img/');
define('IMG_URL_ADMIN',  '../img/');

// Koneksi MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('Koneksi database gagal: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
