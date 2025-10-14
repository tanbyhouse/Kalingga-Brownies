<?php
require(BASE_PATH . '/src/includes/auth-check.php');
require(BASE_PATH . '/src/core/database.php');

$category_id = $_GET['id'] ?? null;
$category = null;
$page_title = 'Add New Category';

if ($category_id) {
    $page_title = 'Edit Category';
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch();
    if (!$category) {
        die('Category not found!');
    }
}

// fetch main categories
$main_categories_stmt = $pdo->query("SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name ASC");
$main_categories = $main_categories_stmt->fetchAll();
?>

<div class="container mx-auto p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-yellow-900 mb-6"><?= $page_title ?></h1>
        
        <form action="index.php?page=categories-save" method="POST">
            <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['id'] ?? '') ?>">

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Category Name</label>
                <input type="text" id="name" name="name" required
                       value="<?= htmlspecialchars($category['name'] ?? '') ?>"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>

            <div class="mb-6">
                <label for="parent_id" class="block text-gray-700 font-bold mb-2">Parent Category (optional)</label>
                <select id="parent_id" name="parent_id"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">-- This is a Main Category --</option>
                    <?php foreach ($main_categories as $main_cat): ?>
                        <?php if (!isset($category['id']) || $category['id'] !== $main_cat['id']): ?>
                            <option value="<?= htmlspecialchars($main_cat['id']) ?>" 
                                    <?= isset($category['parent_id']) && $category['parent_id'] == $main_cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($main_cat['name']) ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <p class="text-sm text-gray-500 mt-2">Select a parent to make this a subcategory.</p>
            </div>

            <div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>