<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Already logged in? No need to see this page.
if (is_logged_in()) {
    header('Location: ' . (is_admin() ? 'admin/index.php' : 'index.php'));
    exit;
}

$errors = array();
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];

    if ($email === '' || $password === '') {
        $errors[] = 'Please enter both email and password.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id, full_name, password, role, is_verified FROM users WHERE email = ?');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            if ((int) $user['is_verified'] === 0) {
                $errors[] = 'Your email is not verified yet. Please check your inbox for the confirmation link.';
            } else {
                // Login OK, remember the user in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                log_action($conn, 'LOGIN', $email . ' logged in');

                if ($user['role'] === 'admin') {
                    header('Location: admin/index.php');
                } else {
                    header('Location: index.php');
                }
                exit;
            }
        } else {
            $errors[] = 'Incorrect email or password.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="wn-form-card">
        <h2>Log in</h2>

        <?php foreach ($errors as $e): ?>
            <div class="alert alert-danger py-2"><?php echo $e; ?></div>
        <?php endforeach; ?>

        <form method="post" action="login.php" novalidate>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-wn w-100">Log in</button>
        </form>

        <p class="text-center mt-3 mb-0">
            No account yet? <a href="register.php">Register here</a>.
        </p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
