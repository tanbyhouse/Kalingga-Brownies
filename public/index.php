<?php
// START THE SESSION ON EVERY PAGE! THIS IS THE MOST IMPORTANT STEP.
session_start();

// Define a base path for cleaner includes
define('BASE_PATH', realpath(__DIR__ . '/../'));

// Include header
require(BASE_PATH . '/src/includes/header.php');

// Include navigation
require(BASE_PATH . '/src/includes/nav.php');

// Simple routing logic
$page = $_GET['page'] ?? 'home'; // Default to 'home' if no page is set

// Whitelist of allowed pages to prevent security issues.
// We will add 'logout' to this list.
$allowed_pages = [
    'home',
    'about',
    'contact',
    'products',
    'login',
    'admin-dashboard',
    'logout' // Add logout here
];

if (in_array($page, $allowed_pages)) {
    // Include the requested page
    require(BASE_PATH . '/src/pages/' . $page . '.php');
} else {
    // If page not found, show a 404 error page
    http_response_code(404);
    require(BASE_PATH . '/src/pages/404.php'); // You should create a 404.php
}

// Include footer
require(BASE_PATH . '/src/includes/footer.php');

?>