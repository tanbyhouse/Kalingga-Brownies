<?php
require(BASE_PATH . '/src/includes/auth-check.php');
require(BASE_PATH . '/src/core/database.php');

// fetch categories
$stmt = $pdo->query("
    SELECT 
        c1.id, 
        c1.name, 
        c2.name AS parent_name 
    FROM categories AS c1
    LEFT JOIN categories AS c2 ON c1.parent_id = c2.id
    ORDER BY c1.name ASC
");
$categories = $stmt->fetchAll();
?>

<div class="container mx-auto p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-yellow-900">Manage Categories</h1>
        <a href="index.php?page=admin-categories-form" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300">
            + Add New Category
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 font-bold">Category Name</th>
                    <th class="p-4 font-bold">Parent Category</th>
                    <th class="p-4 font-bold text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr class="border-b">
                        <td class="p-4"><?= htmlspecialchars($category['name']) ?></td>
                        <td class="p-4 text-gray-600">
                            <?= htmlspecialchars($category['parent_name'] ?? '—') ?>
                        </td>
                        <td class="p-4 text-center">
                            <a href="index.php?page=admin-categories-form&id=<?= urlencode($category['id']) ?>" class="text-blue-600 hover:underline mr-4">Edit</a>
                            <a href="index.php?page=admin-categories-delete&id=<?= urlencode($category['id']) ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>