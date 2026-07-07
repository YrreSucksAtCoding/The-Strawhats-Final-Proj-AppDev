<?php
// Shared header. Every page includes config.php + functions.php before this.
$page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WorkNest &ndash; Office Equipment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>/assets/img/logo.svg">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark wn-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>/index.php">
            <img src="<?php echo BASE_URL; ?>/assets/img/logo.svg" alt="WorkNest logo">
            WorkNest
            <span class="wn-group-badge ms-2">The Strawhats</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link <?php if ($page === 'index.php') echo 'active'; ?>" href="<?php echo BASE_URL; ?>/index.php">Store</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($page === 'about.php') echo 'active'; ?>" href="<?php echo BASE_URL; ?>/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($page === 'cart.php') echo 'active'; ?>" href="<?php echo BASE_URL; ?>/cart.php">
                        Cart <span class="badge text-bg-warning"><?php echo cart_count(); ?></span>
                    </a>
                </li>
                <?php if (is_logged_in()): ?>
                    <?php if (is_admin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/index.php">Admin Panel</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <span class="nav-link disabled">Hi, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-wn-amber btn-sm ms-lg-2" href="<?php echo BASE_URL; ?>/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($page === 'login.php') echo 'active'; ?>" href="<?php echo BASE_URL; ?>/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-wn-amber btn-sm ms-lg-2" href="<?php echo BASE_URL; ?>/register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main>
