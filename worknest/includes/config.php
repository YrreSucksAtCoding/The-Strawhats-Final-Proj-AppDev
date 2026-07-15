<?php
// Database connection settings.
// Change these when deploying to InfinityFree/AwardSpace
// (they give you their own hostname, username, and db name).
define('DB_HOST', 'sql313.infinityfree.com');
define('DB_USER', 'if0_42417565');
define('DB_PASS', 'C9bbDhf0UM9KY');
define('DB_NAME', 'if0_42417565_worknest');

// Base URL of the site, no trailing slash.
// Example on hosting: https://worknest.infinityfreeapp.com
define('BASE_URL', 'https://worknest.infinityfreeapp.com');

// Gmail SMTP settings for PHPMailer (email verification sending)
define('SMTP_USER', 'yrresuguitan0918@gmail.com');
define('SMTP_PASS', 'hhhylekabzvcsips');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');

// One session for the whole site
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
