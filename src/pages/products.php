<?php
require(BASE_PATH . '/src/core/database.php');

// fetch categories
$all_categories_stmt = $pdo->query("SELECT * FROM categories ORDER BY parent_id, name ASC");
$all_categories = $all_categories_stmt->fetchAll();

// manage categories displau
$categories_tree = [];
foreach ($all_categories as $category) {
    if ($category['parent_id'] === null) {
        $categories_tree[$category['id']] = ['details' => $category, 'children' => []];
    } else {
        if (isset($categories_tree[$category['parent_id']])) {
            $categories_tree[$category['parent_id']]['children'][] = $category;
        }
    }
}

// fetch products
$selected_category_id = $_GET['category'] ?? null;
$sql = "SELECT * FROM products";
$params = [];

if ($selected_category_id) {
    // filter products by category_id
    $sql .= " WHERE category_id = ?";
    $params[] = $selected_category_id;
}

$sql .= " ORDER BY name ASC";
$products_stmt = $pdo->prepare($sql);
$products_stmt->execute($params);
$products = $products_stmt->fetchAll();
?>

<div class="container mx-auto p-4 md:p-8">
    <div class="flex flex-col md:flex-row gap-8">
        <aside class="w-full md:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-yellow-900 mb-4">Categories</h2>
                <ul class="space-y-2">
                    <li><a href="index.php?page=products" class="font-bold text-yellow-800 hover:underline">All Products</a></li>
                    
                    <?php foreach ($categories_tree as $main_cat): ?>
                        <li>
                            <a href="index.php?page=products&category=<?= $main_cat['details']['id'] ?>" class="font-semibold text-gray-800 hover:underline">
                                <?= htmlspecialchars($main_cat['details']['name']) ?>
                            </a>
                            <?php if (!empty($main_cat['children'])): ?>
                                <ul class="pl-4 mt-1 space-y-1">
                                    <?php foreach ($main_cat['children'] as $sub_cat): ?>
                                        <li>
                                            <a href="index.php?page=products&category=<?= $sub_cat['id'] ?>" class="text-gray-600 hover:underline">
                                                <?= htmlspecialchars($sub_cat['name']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>

        <main class="w-full md:w-3/4">
            <h1 class="text-4xl font-extrabold text-yellow-900 mb-8">Our Products</h1>
            
            <?php if (empty($products)): ?>
                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                    <p class="text-xl text-gray-600">No products found in this category.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                            <a href="index.php?page=products-detail&id=<?= $product['id'] ?>">
                                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-56 object-cover">
                                <div class="p-6">
                                    <h2 class="text-xl font-bold text-yellow-900"><?= htmlspecialchars($product['name']) ?></h2>
                                    <p class="mt-2 text-gray-600 truncate"><?= htmlspecialchars($product['description']) ?></p>
                                    <div class="mt-4 font-bold text-2xl text-pink-500">
                                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>