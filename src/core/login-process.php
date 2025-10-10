<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: ../public/index.php?page=login');
    exit();
}


require 'database.php';


$username = $_POST['username'];
$password = $_POST['password'];

// find the admin by username
$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch();

// verify admin
if ($admin && password_verify($password, $admin['password_hash'])) {
    // login successful!
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];

    // redirect to the secure admin dashboard.
    header('Location: ../public/index.php?page=admin-dashboard');
    exit(); // Always call exit() after a redirect.
} else {
    // login failed.
    header('Location: ../public/index.php?page=login&error=1');
    exit();
}