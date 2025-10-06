<?php
// Always start the session to access it.
session_start();

// Unset all session variables.
session_unset();

// Destroy the session.
session_destroy();

// Redirect to the login page.
header('Location: ../public/index.php?page=login');
exit();