<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

require_login();

// Must come from checkout with a pending order
if (!isset($_SESSION['pending_order'])) {
    header('Location: cart.php');
    exit;
}

$order_id = (int) $_SESSION['pending_order'];

// Pull the order to show the amount due
$stmt = mysqli_prepare($conn, 'SELECT id, total FROM orders WHERE id = ? AND user_id = ? AND status = "pending"');
mysqli_stmt_bind_param($stmt, 'ii', $order_id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$order) {
    unset($_SESSION['pending_order']);
    header('Location: cart.php');
    exit;
}

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = isset($_POST['method']) ? clean_input($_POST['method']) : '';
    $allowed = array('Cash on Delivery', 'Bank Transfer', 'Credit Card');

    if (!in_array($method, $allowed)) {
        $errors[] = 'Please choose a payment method.';
    }

    // This is a simulated payment only. Card fields are validated for
    // format but never stored, since no real payment API is required yet.
    if ($method === 'Credit Card') {
        $card_no = clean_input($_POST['card_no']);
        $card_name = clean_input($_POST['card_name']);
        if (!preg_match('/^[0-9]{13,16}$/', str_replace(' ', '', $card_no))) {
            $errors[] = 'Card number should be 13 to 16 digits.';
        }
        if ($card_name === '') {
            $errors[] = 'Name on card is required.';
        }
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 'UPDATE orders SET status = "paid", payment_method = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'si', $method, $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        log_action($conn, 'PAYMENT', 'Order #' . $order_id . ' paid via ' . $method);

        // Done: clear the cart and the pending order marker
        $_SESSION['cart'] = array();
        unset($_SESSION['pending_order']);

        header('Location: order_success.php?order=' . $order_id);
        exit;
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="wn-form-card">
        <h2>Payment</h2>
        <p>Amount due for Order #<?php echo $order['id']; ?>:
            <span class="wn-price"><?php echo peso($order['total']); ?></span>
        </p>
        <div class="alert alert-secondary py-2 small">
            Note: this is a simulated payment page. No real charge is made.
        </div>

        <?php foreach ($errors as $e): ?>
            <div class="alert alert-danger py-2"><?php echo $e; ?></div>
        <?php endforeach; ?>

        <form method="post" action="payment.php" novalidate>
            <div class="mb-3">
                <label class="form-label">Payment Method</label>
                <select name="method" id="method" class="form-select" onchange="toggleCard()">
                    <option value="">-- Choose --</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Credit Card">Credit Card</option>
                </select>
            </div>

            <div id="cardFields" style="display:none;">
                <div class="mb-3">
                    <label class="form-label">Card Number</label>
                    <input type="text" name="card_no" class="form-control" placeholder="0000 0000 0000 0000">
                </div>
                <div class="mb-3">
                    <label class="form-label">Name on Card</label>
                    <input type="text" name="card_name" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-wn-amber w-100">Pay Now</button>
        </form>
    </div>
</div>

<script>
function toggleCard() {
    var method = document.getElementById('method').value;
    document.getElementById('cardFields').style.display =
        (method === 'Credit Card') ? 'block' : 'none';
}
</script>

<?php require_once 'includes/footer.php'; ?>
