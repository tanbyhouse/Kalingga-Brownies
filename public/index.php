<?php
session_start();

define('BASE_PATH', realpath(__DIR__ . '/../'));

require(BASE_PATH . '/src/includes/header.php');
require(BASE_PATH . '/src/includes/nav.php');

$page = $_GET['page'] ?? 'home';

$allowed_pages = [
    'home',
    'about',
    'contact',
    'products',
    'login',
    'admin-dashboard',
    'logout',
    'admin-products-list',
    'admin-products-form',
];

if (in_array($page, $allowed_pages)) {
    
    require(BASE_PATH . '/src/pages/' . $page . '.php');
} else {
    http_response_code(404);
    require(BASE_PATH . '/src/includes/404.php');
}

require(BASE_PATH . '/src/includes/footer.php');

?>