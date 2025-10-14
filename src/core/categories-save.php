<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=admin-dashboard');
    exit();
}

// get data form
$category_id = $_POST['category_id'] ?? null;
$name = $_POST['name'] ?? '';
$parent_id = $_POST['parent_id'] ?? null;

if (empty($parent_id)) {
    $parent_id = null;
}

if ($category_id) {
    // update category
    $stmt = $pdo->prepare("UPDATE categories SET name = ?, parent_id = ? WHERE id = ?");
    $stmt->execute([$name, $parent_id, $category_id]);
    $success_message = 'update';
} else {
    // insert new category
    $stmt = $pdo->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
    $stmt->execute([$name, $parent_id]);
    $success_message = 'create';
}

header('Location: index.php?page=admin-categories-list&success=' . $success_message);
exit();