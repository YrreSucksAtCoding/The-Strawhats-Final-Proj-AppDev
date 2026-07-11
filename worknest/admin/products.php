<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

require_admin();

$errors = array();
$success = '';

// Add a new product
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
        $stmt = mysqli_prepare($conn, 'INSERT INTO products (category_id, name, description, price, stock) VALUES (?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'issdi', $category_id, $name, $description, $price, $stock);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        log_action($conn, 'PRODUCT_ADD', 'Added product: ' . $name);
        $success = 'Product added.';
    }
}

$categories = mysqli_query($conn, 'SELECT id, name FROM categories ORDER BY id');
$products = mysqli_query($conn, 'SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY c.id, p.name');

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-lg-9">
            <h2 class="wn-page-title mt-0">Manage Products</h2>

            <?php foreach ($errors as $e): ?>
                <div class="alert alert-danger py-2"><?php echo $e; ?></div>
            <?php endforeach; ?>
            <?php if ($success !== ''): ?>
                <div class="alert alert-success py-2"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="card wn-card p-3 mb-4 h-auto">
                <h5>Add a product</h5>
                <form method="post" action="products.php" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="0">-- Choose --</option>
                                <?php while ($c = mysqli_fetch_assoc($categories)): ?>
                                    <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (&#8369;)</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" min="0" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-wn">Add Product</button>
                </form>
            </div>

            <div class="table-responsive mb-5">
                <table class="table table-bordered align-middle bg-white">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($p = mysqli_fetch_assoc($products)): ?>
                            <tr <?php if ((int) $p['stock'] <= 5) echo 'class="wn-low-stock"'; ?>>
                                <td><?php echo htmlspecialchars($p['name']); ?></td>
                                <td><?php echo htmlspecialchars($p['category_name']); ?></td>
                                <td><?php echo peso($p['price']); ?></td>
                                <td><?php echo $p['stock']; ?></td>
                                <td>
                                    <a href="product_edit.php?id=<?php echo $p['id']; ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
