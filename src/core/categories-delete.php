<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?page=admin-categories-list');
    exit();
}

//  check for child categories to prevent delete
$stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
$stmt->execute([$id]);

header('Location: index.php?page=admin-categories-list&success=delete');
exit();
