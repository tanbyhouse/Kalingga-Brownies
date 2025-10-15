<?php
require(BASE_PATH . '/src/includes/auth-check.php');
require(BASE_PATH . '/src/core/database.php');

$product_id = $_GET['id'] ?? null;
$product = null;
$page_title = 'Add New Product';

if ($product_id) {
    $page_title = 'Edit Product';
    $product_stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $product_stmt->execute([$product_id]);
    $product = $product_stmt->fetch();

    if (!$product) {
        header('Location: index.php?page=admin-products-list');
        exit();
    }
}

// fetch categories
$categories_stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $categories_stmt->fetchAll();
?>

<div class="container mx-auto p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-yellow-900 mb-6"><?= htmlspecialchars($page_title) ?></h1>
        
    <form action="index.php?page=products-save" method="POST" enctype="multipart/form-data">
            <?php if (!empty($product) && isset($product['id'])): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
            <?php endif; ?>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Product Name</label>
          <input type="text" id="name" name="name" required value="<?= htmlspecialchars($product['name'] ?? '') ?>"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price (e.g., 35000)</label>
          <input type="number" id="price" name="price" step="100" required value="<?= htmlspecialchars($product['price'] ?? '') ?>"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-bold mb-2">Category</label>
                <select id="category_id" name="category_id" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">-- Select a Category --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>" <?= (isset($product['category_id']) && $product['category_id'] == $category['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-6">
                <label for="product_image" class="block text-gray-700 font-bold mb-2">Product Image</label>
                <input type="file" id="product_image" name="product_image" <?= empty($product) ? 'required' : '' ?>
                       class="w-full px-3 py-2 border rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                <?php if (!empty($product) && !empty($product['image_url'])): ?>
                    <p class="text-sm text-gray-600 mt-2">Current image:</p>
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="h-24 w-24 object-cover rounded mt-2">
                <?php endif; ?>
                <!-- Live preview removed: display-only form shows current image when editing -->
            </div>

            <div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <?= (!empty($product) ? 'Update Product' : 'Save Product') ?>
                </button>
            </div>
        </form>
    </div>
</div>