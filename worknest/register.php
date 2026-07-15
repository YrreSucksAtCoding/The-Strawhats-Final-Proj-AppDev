<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'includes/phpmailer/PHPMailer.php';
require_once 'includes/phpmailer/SMTP.php';
require_once 'includes/phpmailer/Exception.php';

require_once 'includes/config.php';
require_once 'includes/functions.php';

$errors = array();
$success = '';

// Keep the typed values so the form does not clear itself on an error
$full_name = '';
$email = '';
$address = '';
$contact_no = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = clean_input($_POST['full_name']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $address = clean_input($_POST['address']);
    $contact_no = clean_input($_POST['contact_no']);

    // Validate every field one by one
    if ($full_name === '') {
        $errors[] = 'Complete name is required.';
    }

    if ($email === '') {
        $errors[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if ($password !== $confirm) {
        $errors[] = 'Password and confirm password do not match.';
    }

    if ($address === '') {
        $errors[] = 'Complete address is required.';
    }

    if ($contact_no === '') {
        $errors[] = 'Contact number is required.';
    } elseif (!preg_match('/^[0-9+\-\s]{7,15}$/', $contact_no)) {
        $errors[] = 'Contact number should only contain digits, +, -, or spaces.';
    }

    // Make sure the email is not taken yet
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ?');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = 'That email address is already registered.';
        }
        mysqli_stmt_close($stmt);
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(uniqid($email, true));

        $stmt = mysqli_prepare($conn, 'INSERT INTO users (full_name, email, password, address, contact_no, verify_token) VALUES (?, ?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'ssssss', $full_name, $email, $hashed, $address, $contact_no, $token);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            // Build the confirmation email with the verify link
            $verify_link = BASE_URL . '/verify.php?token=' . $token;
            $subject = 'WorkNest - Confirm your email address';
            $message = "Hi $full_name,\n\n"
                . "Thank you for registering at WorkNest.\n"
                . "Please confirm your email address by opening this link:\n\n"
                . $verify_link . "\n\n"
                . "If you did not register, you can ignore this email.\n\n"
                . "- The Strawhats";

            // Send via Gmail SMTP using PHPMailer
            $mailer = new PHPMailer(true);
            try {
                $mailer->isSMTP();
                $mailer->Host = 'smtp.gmail.com';
                $mailer->SMTPAuth = true;
                $mailer->Username = SMTP_USER;
                $mailer->Password = SMTP_PASS;
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mailer->Port = 587;

                $mailer->setFrom(SMTP_USER, 'WorkNest');
                $mailer->addAddress($email, $full_name);
                $mailer->Subject = $subject;
                $mailer->Body = $message;

                $mailer->send();
            } catch (Exception $e) {
                // Account is still created even if the email fails to send;
                // the user can be verified manually by an admin if needed.
            }

            log_action($conn, 'REGISTER', 'New account registered: ' . $email);

            $success = 'Registration successful! We sent a confirmation link to your email address. '
                . 'Please verify your email before logging in. (If you do not see it, check your Spam folder.)';
            // Clear the form after success
            $full_name = $email = $address = $contact_no = '';
        } else {
            $errors[] = 'Something went wrong while saving your account. Please try again.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="wn-form-card">
        <h2>Create an account</h2>

        <?php foreach ($errors as $e): ?>
            <div class="alert alert-danger py-2"><?php echo $e; ?></div>
        <?php endforeach; ?>

        <?php if ($success !== ''): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post" action="register.php" novalidate>
            <div class="mb-3">
                <label class="form-label">Complete Name</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo $full_name; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Complete Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_no" class="form-control" value="<?php echo $contact_no; ?>" required>
            </div>
            <button type="submit" class="btn btn-wn w-100">Register</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Already have an account? <a href="login.php">Log in here</a>.
        </p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
