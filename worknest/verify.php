<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$status = 'invalid';

if (isset($_GET['token']) && $_GET['token'] !== '') {
    $token = clean_input($_GET['token']);

    // Look for an unverified account holding this token
    $stmt = mysqli_prepare($conn, 'SELECT id, email FROM users WHERE verify_token = ? AND is_verified = 0');
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($user) {
        $stmt = mysqli_prepare($conn, 'UPDATE users SET is_verified = 1, verify_token = NULL WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $user['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        log_action($conn, 'VERIFY_EMAIL', 'Email verified: ' . $user['email']);
        $status = 'ok';
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="wn-form-card text-center">
        <?php if ($status === 'ok'): ?>
            <h2>Email verified!</h2>
            <p>Your account is now active. You can log in and start shopping.</p>
            <a href="login.php" class="btn btn-wn">Go to Login</a>
        <?php else: ?>
            <h2>Invalid link</h2>
            <p>This verification link is invalid or was already used.</p>
            <a href="index.php" class="btn btn-wn">Back to Store</a>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
