<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

require_admin();

// Quick counts for the dashboard cards
$counts = array('products' => 0, 'users' => 0, 'orders' => 0, 'low_stock' => 0);

$result = mysqli_query($conn, 'SELECT COUNT(*) AS c FROM products');
$counts['products'] = mysqli_fetch_assoc($result)['c'];

$result = mysqli_query($conn, 'SELECT COUNT(*) AS c FROM users');
$counts['users'] = mysqli_fetch_assoc($result)['c'];

$result = mysqli_query($conn, 'SELECT COUNT(*) AS c FROM orders');
$counts['orders'] = mysqli_fetch_assoc($result)['c'];

$result = mysqli_query($conn, 'SELECT COUNT(*) AS c FROM products WHERE stock <= 5');
$counts['low_stock'] = mysqli_fetch_assoc($result)['c'];

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-lg-9">
            <h2 class="wn-page-title mt-0">Dashboard</h2>
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card wn-card p-3 text-center">
                        <div class="fs-3 fw-bold"><?php echo $counts['products']; ?></div>
                        <div class="text-muted small">Products</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card wn-card p-3 text-center">
                        <div class="fs-3 fw-bold"><?php echo $counts['users']; ?></div>
                        <div class="text-muted small">Users</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card wn-card p-3 text-center">
                        <div class="fs-3 fw-bold"><?php echo $counts['orders']; ?></div>
                        <div class="text-muted small">Orders</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card wn-card p-3 text-center">
                        <div class="fs-3 fw-bold text-danger"><?php echo $counts['low_stock']; ?></div>
                        <div class="text-muted small">Low stock items</div>
                    </div>
                </div>
            </div>
            <p>Use the menu on the left to manage users, update products and prices, or view the
               inventory and audit log reports.</p>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
