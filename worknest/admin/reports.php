<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

require_admin();

// Inventory report: remaining stock per product
$inventory = mysqli_query($conn, 'SELECT p.name, c.name AS category_name, p.price, p.stock FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.stock ASC');

// Audit log: latest activities first
// Optionally filter to one user feature added - Yrre
$filter_user = 0;
if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $filter_user = (int) $_GET['user'];
}

if ($filter_user > 0) {
    $stmt = mysqli_prepare($conn, 'SELECT * FROM audit_log WHERE user_id = ? ORDER BY created_at DESC LIMIT 200');
    mysqli_stmt_bind_param($stmt, 'i', $filter_user);
    mysqli_stmt_execute($stmt);
    $logs = mysqli_stmt_get_result($stmt);
} else {
    $logs = mysqli_query($conn, 'SELECT * FROM audit_log ORDER BY created_at DESC LIMIT 200');
}

$users = mysqli_query($conn, 'SELECT id, full_name FROM users ORDER BY full_name');

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-lg-9">
            <h2 class="wn-page-title mt-0">Reports</h2>

            <h5 class="mt-3">Inventory report</h5>
            <p class="text-muted small">Items with 5 or fewer units left are highlighted.</p>
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle bg-white">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Remaining Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($inventory)): ?>
                            <tr <?php if ((int) $row['stock'] <= 5) echo 'class="wn-low-stock"'; ?>>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                <td><?php echo peso($row['price']); ?></td>
                                <td><?php echo $row['stock']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <h5>Audit log</h5>
            <p class="text-muted small">All recorded activities of users logged in to the system (latest 200).</p>

            <form method="get" action="reports.php" class="row g-2 mb-3" style="max-width:420px;">
                <div class="col-8">
                    <select name="user" class="form-select form-select-sm">
                        <option value="0">All users</option>
                        <?php while ($u = mysqli_fetch_assoc($users)): ?>
                            <option value="<?php echo $u['id']; ?>" <?php if ($filter_user === (int) $u['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($u['full_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-wn btn-sm w-100">Filter</button>
                </div>
            </form>

            <div class="table-responsive mb-5">
                <table class="table table-bordered table-sm align-middle bg-white">
                    <thead>
                        <tr>
                            <th>Date &amp; Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($log = mysqli_fetch_assoc($logs)): ?>
                            <tr>
                                <td><?php echo date('M d, Y h:i A', strtotime($log['created_at'])); ?></td>
                                <td><?php echo htmlspecialchars($log['user_name']); ?></td>
                                <td><span class="badge text-bg-light border"><?php echo htmlspecialchars($log['action']); ?></span></td>
                                <td><?php echo htmlspecialchars($log['details']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
