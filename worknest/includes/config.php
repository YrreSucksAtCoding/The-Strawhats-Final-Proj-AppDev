<?php
// Database connection settings.
// Change these when deploying to InfinityFree/AwardSpace
// (they give you their own hostname, username, and db name).
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'worknest_db');

// Base URL of the site, no trailing slash.
// Example on hosting: https://worknest.infinityfreeapp.com
define('BASE_URL', 'http://localhost/YereAppDevHome/The-Strawhats-Final-Proj-AppDev/worknest');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');

// One session for the whole site
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
