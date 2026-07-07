<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

require_admin();

$errors = array();
$success = '';

// Add a new user (admins can create both roles here)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = clean_input($_POST['full_name']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $address = clean_input($_POST['address']);
    $contact_no = clean_input($_POST['contact_no']);
    $role = ($_POST['role'] === 'admin') ? 'admin' : 'buyer';

    if ($full_name === '') {
        $errors[] = 'Complete name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($address === '') {
        $errors[] = 'Address is required.';
    }
    if ($contact_no === '') {
        $errors[] = 'Contact number is required.';
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ?');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = 'That email is already registered.';
        }
        mysqli_stmt_close($stmt);
    }

    if (empty($errors)) {
        // Accounts created by an admin are verified right away
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, 'INSERT INTO users (full_name, email, password, address, contact_no, role, is_verified) VALUES (?, ?, ?, ?, ?, ?, 1)');
        mysqli_stmt_bind_param($stmt, 'ssssss', $full_name, $email, $hashed, $address, $contact_no, $role);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        log_action($conn, 'USER_ADD', 'Admin created ' . $role . ' account: ' . $email);
        $success = 'User account created.';
    }
}

$users = mysqli_query($conn, 'SELECT id, full_name, email, role, is_verified, created_at FROM users ORDER BY created_at DESC');

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col-lg-9">
            <h2 class="wn-page-title mt-0">Manage Users</h2>

            <?php foreach ($errors as $e): ?>
                <div class="alert alert-danger py-2"><?php echo $e; ?></div>
            <?php endforeach; ?>
            <?php if ($success !== ''): ?>
                <div class="alert alert-success py-2"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="card wn-card p-3 mb-4">
                <h5>Add a user</h5>
                <form method="post" action="users.php" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Complete Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="buyer">Buyer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_no" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-wn">Add User</button>
                </form>
            </div>

            <div class="table-responsive mb-5">
                <table class="table table-bordered align-middle bg-white">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Verified</th>
                            <th>Registered</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($u = mysqli_fetch_assoc($users)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($u['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td>
                                    <span class="badge <?php echo $u['role'] === 'admin' ? 'text-bg-dark' : 'text-bg-secondary'; ?>">
                                        <?php echo $u['role']; ?>
                                    </span>
                                </td>
                                <td><?php echo $u['is_verified'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
                                <td>
                                    <a href="user_edit.php?id=<?php echo $u['id']; ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
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
