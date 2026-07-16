// Product Edit Page not working - Ains
// Fixed - Yrre

<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

require_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$id = (int) $_GET['id'];
$errors = array();
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $description = clean_input($_POST['description']);
    $category_id = (int) $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if ($name === '') {
        $errors[] = 'Product name is required.';
    }
    if ($category_id <= 0) {
        $errors[] = 'Please pick a category.';
    }
    if (!is_numeric($price) || $price < 0) {
        $errors[] = 'Price must be a valid number.';
    }
    if (!is_numeric($stock) || $stock < 0 || floor($stock) != $stock) {
        $errors[] = 'Stock must be a whole number.';
    }

    if (empty($errors)) {
        $price = (float) $price;
        $stock = (int) $stock;
        $stmt = mysqli_prepare($conn, 'UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, stock = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'issdii', $category_id, $name, $description, $price, $stock, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        log_action($conn, 'PRODUCT_EDIT', 'Edited product #' . $id . ' (' . $name . ')');
        $success = 'Product updated.';
    }
}

// Load current values
$stmt = mysqli_prepare($conn, 'SELECT * FROM products WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    header('Location: products.php');
    exit;
}

$categories = mysqli_query($conn, 'SELECT id, name FROM categories ORDER BY id');

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-lg-9">
            <h2 class="wn-page-title mt-0">Edit Product</h2>

            <?php foreach ($errors as $e): ?>
                <div class="alert alert-danger py-2"><?php echo $e; ?></div>
            <?php endforeach; ?>
            <?php if ($success !== ''): ?>
                <div class="alert alert-success py-2"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="card wn-card p-3 mb-5" style="max-width:640px;">
                <form method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <?php while ($c = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?php echo $c['id']; ?>"
                                    <?php if ((int) $c['id'] === (int) $product['category_id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($c['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (&#8369;)</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control"
                                   value="<?php echo $product['price']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" min="0" class="form-control"
                                   value="<?php echo $product['stock']; ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-wn">Save Changes</button>
                    <a href="products.php" class="btn btn-outline-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
