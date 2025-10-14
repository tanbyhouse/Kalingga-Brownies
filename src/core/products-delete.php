<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/database.php';

$product_id = $_GET['id'] ?? null;
if (!$product_id) {
    header('Location: index.php?page=admin-products-list');
    exit();
}

// fetch image path
$stmt = $pdo->prepare('SELECT image_url FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch();
if ($product && !empty($product['image_url'])) {
    $image_path = realpath(__DIR__ . '/../../public' . $product['image_url']);
    if ($image_path && file_exists($image_path)) {
        @unlink($image_path);
    }
}

// delete product
$stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
$stmt->execute([$product_id]);

header('Location: index.php?page=admin-products-list&success=delete');
exit();