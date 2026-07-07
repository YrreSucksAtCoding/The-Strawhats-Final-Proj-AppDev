<?php
// Shared helper functions used across the site.

// Standard cleanup for form inputs before validating them.
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function is_admin()
{
    return is_logged_in() && $_SESSION['role'] === 'admin';
}

// Pages that need a logged in buyer/any user
function require_login()
{
    if (!is_logged_in()) {
        header('Location: ' . BASE_URL . '/login.php');
        exit;
    }
}

// Pages that only admins should reach
function require_admin()
{
    if (!is_admin()) {
        header('Location: ' . BASE_URL . '/login.php');
        exit;
    }
}

// Writes one row to the audit log so the reports page
// can show what each logged in user did.
function log_action($conn, $action, $details = '')
{
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $user_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Guest';

    $stmt = mysqli_prepare($conn, 'INSERT INTO audit_log (user_id, user_name, action, details) VALUES (?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'isss', $user_id, $user_name, $action, $details);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Total number of items currently in the session cart (for the navbar badge)
function cart_count()
{
    if (empty($_SESSION['cart'])) {
        return 0;
    }
    $count = 0;
    foreach ($_SESSION['cart'] as $qty) {
        $count += $qty;
    }
    return $count;
}

// Peso formatting so prices look the same everywhere
function peso($amount)
{
    return '&#8369;' . number_format($amount, 2);
}
