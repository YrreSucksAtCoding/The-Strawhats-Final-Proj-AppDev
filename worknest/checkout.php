<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

require_login();

// Nothing to check out?
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Prefill the shipping form with the account's saved details
$stmt = mysqli_prepare($conn, 'SELECT full_name, address, contact_no FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$account = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$ship_name = $account['full_name'];
$ship_address = $account['address'];
$ship_contact = $account['contact_no'];

$errors = array();

// Build cart items + total (re-checked against the database)
$items = array();
$total = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    $stmt = mysqli_prepare($conn, 'SELECT id, name, price, stock FROM products WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $pid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $p = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($p) {
        $p['qty'] = $qty;
        $p['subtotal'] = $p['price'] * $qty;
        $total += $p['subtotal'];
        $items[] = $p;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ship_name = clean_input($_POST['ship_name']);
    $ship_address = clean_input($_POST['ship_address']);
    $ship_contact = clean_input($_POST['ship_contact']);

    if ($ship_name === '') {
        $errors[] = 'Recipient name is required.';
    }
    if ($ship_address === '') {
        $errors[] = 'Shipping address is required.';
    }
    if ($ship_contact === '') {
        $errors[] = 'Contact number is required.';
    }

    // Final stock check before saving the order
    foreach ($items as $item) {
        if ($item['qty'] > (int) $item['stock']) {
            $errors[] = 'Not enough stock left for ' . htmlspecialchars($item['name']) . '.';
        }
    }

    if (empty($errors)) {
        // Save the order header first
        $user_id = $_SESSION['user_id'];
        $stmt = mysqli_prepare($conn, 'INSERT INTO orders (user_id, ship_name, ship_address, ship_contact, total) VALUES (?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'isssd', $user_id, $ship_name, $ship_address, $ship_contact, $total);
        mysqli_stmt_execute($stmt);
        $order_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Then each line item, and deduct the stock
        foreach ($items as $item) {
            $stmt = mysqli_prepare($conn, 'INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'iisdi', $order_id, $item['id'], $item['name'], $item['price'], $item['qty']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($conn, 'UPDATE products SET stock = stock - ? WHERE id = ?');
            mysqli_stmt_bind_param($stmt, 'ii', $item['qty'], $item['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        log_action($conn, 'CHECKOUT', 'Placed order #' . $order_id . ' (total ' . number_format($total, 2) . ')');

        // Remember which order we are paying for, then go to payment
        $_SESSION['pending_order'] = $order_id;
        header('Location: payment.php');
        exit;
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <h2 class="wn-page-title">Checkout</h2>

    <?php foreach ($errors as $e): ?>
        <div class="alert alert-danger py-2"><?php echo $e; ?></div>
    <?php endforeach; ?>

    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="card wn-card p-3">
                <h5 class="mb-3">Shipping details</h5>
                <form method="post" action="checkout.php" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Recipient Name</label>
                        <input type="text" name="ship_name" class="form-control" value="<?php echo htmlspecialchars($ship_name); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shipping Address</label>
                        <input type="text" name="ship_address" class="form-control" value="<?php echo htmlspecialchars($ship_address); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="ship_contact" class="form-control" value="<?php echo htmlspecialchars($ship_contact); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-wn-amber">Continue to Payment</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card wn-card p-3">
                <h5 class="mb-3">Order summary</h5>
                <table class="table table-sm">
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?> &times; <?php echo $item['qty']; ?></td>
                                <td class="text-end"><?php echo peso($item['subtotal']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="fw-bold">
                            <td>Total</td>
                            <td class="text-end"><?php echo peso($total); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
