<?php
// We must start the session to be able to save login state.
session_start();

// This script should only be accessed via a POST request.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect to login page if accessed directly.
    header('Location: ../public/index.php?page=login');
    exit();
}

// Include the database connection file.
require 'database.php';

// Get the submitted username and password from the form.
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare a secure SQL statement to find the admin by username.
// Using a prepared statement prevents SQL injection attacks.
$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch();

// Verify if an admin was found and if the submitted password matches the hashed password in the database.
if ($admin && password_verify($password, $admin['password_hash'])) {
    // Login successful!
    // Store the admin's ID and username in the session.
    // This is how we remember that they are logged in.
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];

    // Redirect the user to the secure admin dashboard.
    header('Location: ../public/index.php?page=admin-dashboard');
    exit(); // Always call exit() after a redirect.
} else {
    // Login failed.
    // Redirect back to the login page with an error flag in the URL.
    header('Location: ../public/index.php?page=login&error=1');
    exit();
}