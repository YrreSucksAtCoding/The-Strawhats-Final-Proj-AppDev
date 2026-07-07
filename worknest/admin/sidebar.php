<?php $admin_page = basename($_SERVER['PHP_SELF']); ?>
<div class="col-lg-3 mb-4">
    <div class="wn-admin-side">
        <a href="index.php" class="<?php if ($admin_page === 'index.php') echo 'active'; ?>">Dashboard</a>
        <a href="users.php" class="<?php if ($admin_page === 'users.php' || $admin_page === 'user_edit.php') echo 'active'; ?>">Manage Users</a>
        <a href="products.php" class="<?php if ($admin_page === 'products.php' || $admin_page === 'product_edit.php') echo 'active'; ?>">Manage Products</a>
        <a href="reports.php" class="<?php if ($admin_page === 'reports.php') echo 'active'; ?>">Reports</a>
        <a href="../index.php">View Store</a>
    </div>
</div>
