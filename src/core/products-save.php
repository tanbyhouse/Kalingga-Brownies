<?php
session_start();
define('BASE_PATH', realpath(__DIR__ . '/../../'));

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php?page=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=admin-dashboard');
    exit();
}

require_once __DIR__ . '/database.php';

// read inputs
$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = $_POST['price'] ?? '';
$category_id = $_POST['category_id'] ?? '';
$image_db_path = null;

// form validation
if (empty($name) || empty($price) || empty($category_id)) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    $redirect = 'index.php?page=admin-products-form';
    if ($id) $redirect .= '&id=' . urlencode($id);
    header('Location: ' . $redirect);
    exit();
}

// file upload handling
if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['product_image']['tmp_name'];
        $file_name = $_FILES['product_image']['name'];
        $file_size = $_FILES['product_image']['size'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error'] = 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.';
            header('Location: index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : ''));
            exit();
        }

        if ($file_size > 2000000) {
            $_SESSION['error'] = 'File size is too large. Maximum size is 2MB.';
            header('Location: index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : ''));
            exit();
        }

        $upload_dir = BASE_PATH . '/public/img/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $new_filename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name);
        $dest_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            $image_db_path = '/img/' . $new_filename;
        } else {
            $_SESSION['error'] = 'Failed to upload file. Please try again.';
            header('Location: index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : ''));
            exit();
        }
    } else {
        $upload_error = $_FILES['product_image']['error'];
        $_SESSION['error'] = 'File upload failed. Error code: ' . $upload_error;
        header('Location: index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : ''));
        exit();
    }
}

try {
    if ($id) {
        // update product
        $sql = 'UPDATE products SET name = ?, description = ?, price = ?, category_id = ?';
        $params = [$name, $description, $price, $category_id];

        if ($image_db_path) {
            $sql .= ', image_url = ?';
            $params[] = $image_db_path;
        }

        $sql .= ' WHERE id = ?';
        $params[] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $_SESSION['success'] = 'Product updated successfully!';
        header('Location: index.php?page=admin-products-list&success=update');
        exit();
    } else {
        // image upload handling
        if (!$image_db_path) {
            $_SESSION['error'] = 'Please upload a product image.';
            header('Location: index.php?page=admin-products-form');
            exit();
        }

        $stmt = $pdo->prepare(
            'INSERT INTO products (name, description, price, category_id, image_url) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$name, $description, $price, $category_id, $image_db_path]);

        $_SESSION['success'] = 'Product added successfully!';
        header('Location: index.php?page=admin-products-list&success=create');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    header('Location: index.php?page=admin-products-form' . ($id ? '&id=' . urlencode($id) : ''));
    exit();
}