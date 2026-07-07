<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Category filter from the tabs. 0 means show everything.
$cat_id = 0;
if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $cat_id = (int) $_GET['category'];
}

// Get categories for the filter tabs
$categories = array();
$result = mysqli_query($conn, 'SELECT id, name FROM categories ORDER BY id');
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Get products, filtered by category if one was picked
if ($cat_id > 0) {
    $stmt = mysqli_prepare($conn, 'SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? ORDER BY p.name');
    mysqli_stmt_bind_param($stmt, 'i', $cat_id);
    mysqli_stmt_execute($stmt);
    $products = mysqli_stmt_get_result($stmt);
} else {
    $products = mysqli_query($conn, 'SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY c.id, p.name');
}

require_once 'includes/header.php';
?>

<section class="wn-hero">
    <div class="container">
        <h1>Outfit your workspace.</h1>
        <p>WorkNest carries chairs, desks, storage, and accessories for offices of any size. Browse the catalog below and add items to your cart.</p>
    </div>
</section>

<div class="container">
    <?php if (isset($_GET['added'])): ?>
        <div class="alert alert-success">Item added to your cart.</div>
    <?php endif; ?>
    <?php if (isset($_GET['nostock'])): ?>
        <div class="alert alert-warning">Sorry, that item does not have enough stock left.</div>
    <?php endif; ?>

    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link <?php if ($cat_id === 0) echo 'active'; ?>" href="index.php">All</a>
        </li>
        <?php foreach ($categories as $c): ?>
            <li class="nav-item">
                <a class="nav-link <?php if ($cat_id === (int) $c['id']) echo 'active'; ?>"
                   href="index.php?category=<?php echo $c['id']; ?>">
                    <?php echo htmlspecialchars($c['name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="row g-4 mb-5">
        <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card wn-card">
                    <?php $img = 'assets/img/products/' . $p['id'] . '.jpg'; ?>
                    <?php if (file_exists($img)): ?>
                        <img src="<?php echo BASE_URL . '/' . $img; ?>" class="wn-thumb-img" alt="<?php echo htmlspecialchars($p['name']); ?>">
                    <?php else: ?>
                        <div class="wn-thumb">&#128188;</div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <span class="badge text-bg-light border mb-2 align-self-start">
                            <?php echo htmlspecialchars($p['category_name']); ?>
                        </span>
                        <h5 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h5>
                        <p class="card-text small text-muted"><?php echo htmlspecialchars($p['description']); ?></p>
                        <div class="mt-auto">
                            <div class="wn-price mb-2"><?php echo peso($p['price']); ?></div>
                            <?php if ((int) $p['stock'] > 0): ?>
                                <form method="post" action="cart.php">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                                    <button type="submit" class="btn btn-wn w-100 btn-sm">Add to Cart</button>
                                </form>
                                <small class="text-muted"><?php echo $p['stock']; ?> in stock</small>
                            <?php else: ?>
                                <button class="btn btn-secondary w-100 btn-sm" disabled>Out of stock</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>