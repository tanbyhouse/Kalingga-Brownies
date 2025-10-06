<?php
// Define a base path for cleaner includes
define('BASE_PATH', realpath(__DIR__ . '/../'));

// Include header
require(BASE_PATH . '../src/includes/header.php');

// Include navigation
require(BASE_PATH . '../src/includes/nav.php');

// Simple routing logic
$page = $_GET['page'] ?? 'home';

// Whitelist of allowed pages to prevent security issues
$allowed_pages = ['home', 'about', 'contact', 'products', 'login', 'admin-dashboard'];

if (in_array($page, $allowed_pages)) {
    // Include the requested page
    require(BASE_PATH . '../src/pages/' . $page . '.php');
} else {
    // If page not found, show a 404 error page
    http_response_code(404);
    require(BASE_PATH . '../src/includes/404.php');
}

// Include footer
require(BASE_PATH . '../src/includes/footer.php');

?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./css/output.css" rel="stylesheet">
</head>
<body>
 
</body>
</html>