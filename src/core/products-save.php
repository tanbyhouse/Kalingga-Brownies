<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=admin-dashboard');
    exit();
}

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = $_POST['price'] ?? '';
$category_id = $_POST['category_id'] ?? '';

// validation
if ($name === '' || $price === '' || $category_id === '') {
    $_SESSION['error'] = 'Please fill in all required fields.';
    $loc = 'index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : '');
    header('Location: ' . $loc);
    exit();
}

// upload image if provided, return db path or null
function handleImageUpload($basePath)
{
    if (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return false;
    if ($_FILES['product_image']['size'] > 2_000_000) return false;

    $uploadDir = $basePath . '/public/img/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $filename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['product_image']['name']);
    $dest = $uploadDir . $filename;
    if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $dest)) return false;
    return '/img/' . $filename;
}

$image_db_path = handleImageUpload(realpath(__DIR__ . '/../../'));
if ($image_db_path === false) {
    $_SESSION['error'] = 'Image upload failed or invalid file.';
    header('Location: index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : ''));
    exit();
}

try {
    if ($id) {
        // keep image_url unchanged if no new upload
        if ($image_db_path) {
            $stmt = $pdo->prepare('UPDATE products SET name=?, description=?, price=?, category_id=?, image_url=? WHERE id=?');
            $stmt->execute([$name,$description,$price,$category_id,$image_db_path,$id]);
        } else {
            $stmt = $pdo->prepare('UPDATE products SET name=?, description=?, price=?, category_id=? WHERE id=?');
            $stmt->execute([$name,$description,$price,$category_id,$id]);
        }
        $_SESSION['success'] = 'Product updated successfully!';
        header('Location: index.php?page=admin-products-list&success=update');
        exit();
    }

    // requires image
    if (!$image_db_path) {
        $_SESSION['error'] = 'Please upload a product image.';
        header('Location: index.php?page=admin-products-form');
        exit();
    }
    $stmt = $pdo->prepare('INSERT INTO products (name,description,price,category_id,image_url) VALUES (?,?,?,?,?)');
    $stmt->execute([$name,$description,$price,$category_id,$image_db_path]);
    $_SESSION['success'] = 'Product added successfully!';
    header('Location: index.php?page=admin-products-list&success=create');
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    header('Location: index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : ''));
    exit();
}