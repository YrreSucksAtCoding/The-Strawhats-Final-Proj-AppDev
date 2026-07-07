<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

require_login();

$order = null;

if (isset($_GET['order']) && is_numeric($_GET['order'])) {
    $order_id = (int) $_GET['order'];

    $stmt = mysqli_prepare($conn, 'SELECT * FROM orders WHERE id = ? AND user_id = ?');
    mysqli_stmt_bind_param($stmt, 'ii', $order_id, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="wn-form-card text-center">
        <?php if ($order): ?>
            <h2>Thank you!</h2>
            <p>Your order <strong>#<?php echo $order['id']; ?></strong> has been placed and marked as
                <span class="badge text-bg-success"><?php echo $order['status']; ?></span>.</p>
            <p>Total: <span class="wn-price"><?php echo peso($order['total']); ?></span><br>
               Payment method: <?php echo htmlspecialchars($order['payment_method']); ?><br>
               Shipping to: <?php echo htmlspecialchars($order['ship_address']); ?></p>
            <a href="index.php" class="btn btn-wn">Back to Store</a>
        <?php else: ?>
            <h2>Order not found</h2>
            <a href="index.php" class="btn btn-wn">Back to Store</a>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
