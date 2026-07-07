<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

require_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: users.php');
    exit;
}

$id = (int) $_GET['id'];
$errors = array();
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = clean_input($_POST['full_name']);
    $address = clean_input($_POST['address']);
    $contact_no = clean_input($_POST['contact_no']);
    $role = ($_POST['role'] === 'admin') ? 'admin' : 'buyer';
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;
    $new_password = $_POST['new_password'];

    if ($full_name === '') {
        $errors[] = 'Complete name is required.';
    }
    if ($address === '') {
        $errors[] = 'Address is required.';
    }
    if ($contact_no === '') {
        $errors[] = 'Contact number is required.';
    }

    // Do not let an admin demote their own account by accident
    if ($id === (int) $_SESSION['user_id'] && $role !== 'admin') {
        $errors[] = 'You cannot remove your own admin role.';
    }

    if ($new_password !== '' && strlen($new_password) < 8) {
        $errors[] = 'New password must be at least 8 characters.';
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 'UPDATE users SET full_name = ?, address = ?, contact_no = ?, role = ?, is_verified = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'ssssii', $full_name, $address, $contact_no, $role, $is_verified, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Optional password reset
        if ($new_password !== '') {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, 'UPDATE users SET password = ? WHERE id = ?');
            mysqli_stmt_bind_param($stmt, 'si', $hashed, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        log_action($conn, 'USER_EDIT', 'Admin edited user #' . $id);
        $success = 'User updated.';
    }
}

// Load the user (after any update so the form shows fresh data)
$stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    header('Location: users.php');
    exit;
}

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-lg-9">
            <h2 class="wn-page-title mt-0">Edit User</h2>

            <?php foreach ($errors as $e): ?>
                <div class="alert alert-danger py-2"><?php echo $e; ?></div>
            <?php endforeach; ?>
            <?php if ($success !== ''): ?>
                <div class="alert alert-success py-2"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="card wn-card p-3 mb-5" style="max-width:640px;">
                <form method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Email (cannot be changed)</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Complete Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_no" class="form-control" value="<?php echo htmlspecialchars($user['contact_no']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="buyer" <?php if ($user['role'] === 'buyer') echo 'selected'; ?>>Buyer</option>
                                <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_verified" id="is_verified" class="form-check-input"
                            <?php if ($user['is_verified']) echo 'checked'; ?>>
                        <label class="form-check-label" for="is_verified">Email verified</label>
                    </div>
                    <button type="submit" class="btn btn-wn">Save Changes</button>
                    <a href="users.php" class="btn btn-outline-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
