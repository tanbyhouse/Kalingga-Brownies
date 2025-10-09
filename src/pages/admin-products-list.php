<?php
require(BASE_PATH . '/src/includes/auth-check.php');
require(BASE_PATH . '/src/core/database.php');

// fetch products
$stmt = $pdo->query("SELECT * FROM products ORDER BY name ASC");
$products = $stmt->fetchAll();
?>

<div class="container mx-auto p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-yellow-900">Manage Products</h1>
        <a href="index.php?page=admin-products-form" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300">
            + Add New Product
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg overflow-x-auto">
        <?php if (empty($products)): ?>
            <p class="text-center text-gray-500">No products found. Click "Add New Product" to get started!</p>
        <?php else: ?>
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 font-bold">ID</th>
                        <th class="p-4 font-bold">Image</th>
                        <th class="p-4 font-bold">Name</th>
                        <th class="p-4 font-bold">Price</th>
                        <th class="p-4 font-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr class="border-b">
                            <td class="p-4"><?= htmlspecialchars($product['id']) ?></td>
                            <td class="p-4">
                                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="h-16 w-16 object-cover rounded">
                            </td>
                            <td class="p-4"><?= htmlspecialchars($product['name']) ?></td>
                            <td class="p-4">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td class="p-4 text-center">
                                <a href="index.php?page=admin-product-form&id=<?= $product['id'] ?>" class="text-blue-600 hover:underline mr-4">Edit</a>
                                <a href="index.php?page=admin-product-delete&id=<?= $product['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>