<?php
session_start();

// Use absolute paths relative to this file to ensure includes work
require_once __DIR__ . 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    // Check if a user was found AND if the password is correct.
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        // Redirect to the public front controller which will include the admin-dashboard page
        header('Location: ../public/index.php?page=admin-dashboard');
        exit();
    } else {
        header('Location: ../public/index.php?page=login&error=1');
        exit();
    }
} else {
    header('Location: ../public/index.php?page=login');
    exit();
}