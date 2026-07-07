<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// The cart lives in the session as: product_id => quantity
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle add / update / remove actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add' && isset($_POST['product_id'])) {
        $pid = (int) $_POST['product_id'];

        // Check the product exists and how much stock it has
        $stmt = mysqli_prepare($conn, 'SELECT id, name, stock FROM products WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $pid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($product) {
            $current = isset($_SESSION['cart'][$pid]) ? $_SESSION['cart'][$pid] : 0;
            if ($current + 1 <= (int) $product['stock']) {
                $_SESSION['cart'][$pid] = $current + 1;
                log_action($conn, 'CART_ADD', 'Added to cart: ' . $product['name']);
                header('Location: index.php?added=1');
            } else {
                header('Location: index.php?nostock=1');
            }
            exit;
        }
    }

    if ($action === 'update' && isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $pid => $qty) {
            $pid = (int) $pid;
            $qty = (int) $qty;
            if ($qty <= 0) {
                unset($_SESSION['cart'][$pid]);
            } elseif (isset($_SESSION['cart'][$pid])) {
                // Cap the quantity at the available stock
                $stmt = mysqli_prepare($conn, 'SELECT stock FROM products WHERE id = ?');
                mysqli_stmt_bind_param($stmt, 'i', $pid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);

                if ($row) {
                    $_SESSION['cart'][$pid] = min($qty, (int) $row['stock']);
                }
            }
        }
        log_action($conn, 'CART_UPDATE', 'Cart quantities updated');
        header('Location: cart.php');
        exit;
    }

}

// Remove one item (link on each cart row)
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $pid = (int) $_GET['remove'];
    if (isset($_SESSION['cart'][$pid])) {
        unset($_SESSION['cart'][$pid]);
        log_action($conn, 'CART_REMOVE', 'Removed product #' . $pid . ' from cart');
    }
    header('Location: cart.php');
    exit;
}

// Build the list of cart items for display
$items = array();
$total = 0;

if (!empty($_SESSION['cart'])) {
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
}

require_once 'includes/header.php';
?>

<div class="container">
    <h2 class="wn-page-title">Your Cart</h2>

    <?php if (empty($items)): ?>
        <div class="alert alert-info">
            Your cart is empty. <a href="index.php">Browse the store</a> to add items.
        </div>
    <?php else: ?>
        <form method="post" action="cart.php">
            <input type="hidden" name="action" value="update">
            <div class="table-responsive">
                <table class="table table-bordered align-middle bg-white">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="width:120px;">Price</th>
                            <th style="width:110px;">Quantity</th>
                            <th style="width:130px;">Subtotal</th>
                            <th style="width:100px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo peso($item['price']); ?></td>
                                <td>
                                    <input type="number" name="qty[<?php echo $item['id']; ?>]"
                                           value="<?php echo $item['qty']; ?>"
                                           min="0" max="<?php echo $item['stock']; ?>"
                                           class="form-control form-control-sm">
                                </td>
                                <td><?php echo peso($item['subtotal']); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $item['id']; ?>"
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Remove this item from your cart?');">
                                        Remove
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end bg-white">Total</th>
                            <th class="bg-white"><?php echo peso($total); ?></th>
                            <th class="bg-white"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between mb-5">
                <button type="submit" class="btn btn-outline-secondary">Update Quantities</button>
                <a href="checkout.php" class="btn btn-wn-amber">Proceed to Checkout</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
