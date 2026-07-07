<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (is_logged_in()) {
    log_action($conn, 'LOGOUT', $_SESSION['full_name'] . ' logged out');
}

// Wipe the session (this also empties the cart)
session_unset();
session_destroy();

header('Location: index.php');
exit;
