<?php
// One-time setup script.
// Run this ONCE in the browser after importing worknest.sql,
// then DELETE this file from the server.
//
// It creates:
//   admin account:  admin@worknest.local  / Admin@1234
//   test buyer:     buyer@worknest.local  / Buyer@1234

require_once 'includes/config.php';

$accounts = array(
    array(
        'full_name' => 'WorkNest Administrator',
        'email' => 'admin@worknest.local',
        'password' => 'Admin@1234',
        'address' => 'WorkNest HQ, Quezon City',
        'contact_no' => '09170000001',
        'role' => 'admin'
    ),
    array(
        'full_name' => 'Test Buyer',
        'email' => 'buyer@worknest.local',
        'password' => 'Buyer@1234',
        'address' => '123 Sample St., Quezon City',
        'contact_no' => '09170000002',
        'role' => 'buyer'
    )
);

foreach ($accounts as $acc) {
    // Skip if the account already exists
    $stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 's', $acc['email']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    if ($exists) {
        echo $acc['email'] . ' already exists, skipped.<br>';
        continue;
    }

    $hashed = password_hash($acc['password'], PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, 'INSERT INTO users (full_name, email, password, address, contact_no, role, is_verified) VALUES (?, ?, ?, ?, ?, ?, 1)');
    mysqli_stmt_bind_param($stmt, 'ssssss', $acc['full_name'], $acc['email'], $hashed, $acc['address'], $acc['contact_no'], $acc['role']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo 'Created ' . $acc['role'] . ' account: ' . $acc['email'] . '<br>';
}

echo '<br>Done. Delete setup_accounts.php from the server now.';
