<?php
// Define a base path for cleaner includes
define('BASE_PATH', realpath(__DIR__ . '/../'));

// Include header
require(BASE_PATH . '../src/includes/header.php');

// Include navigation
require(BASE_PATH . '../src/includes/nav.php');

// Simple routing logic
$page = $_GET['page'] ?? 'home'; // Default to 'home' if no page is set

// Whitelist of allowed pages to prevent security issues
$allowed_pages = ['home', 'about', 'contact', 'products'];

if (in_array($page, $allowed_pages)) {
    // Include the requested page
    require(BASE_PATH . '/src/pages/' . $page . '.php');
} else {
    // If page not found, show a 404 error page
    http_response_code(404);
    require(BASE_PATH . 'src\includes\404.php'); // You should create a 404.php
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
  <h1 class="text-3xl bg-red-200 font-bold underline">
    Hello world!
  </h1>
</body>
</html>