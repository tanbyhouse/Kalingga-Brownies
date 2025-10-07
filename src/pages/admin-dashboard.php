<?php
require(BASE_PATH . '/src/includes/auth-check.php');
?>

<div class="container mx-auto p-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-yellow-900">
                Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>!
            </h1>

            <a href="index.php?page=logout" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                Log Out
            </a>
        </div>
        <p class="text-gray-700">This is your secure admin dashboard. From here, you will be able to manage your products, categories, and view customer messages.</p>
        <div class="mt-6">
            <a href="index.php?page=admin-products-list" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Manage Products
            </a>
            <a href="#" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-4">View Messages</a>
        </div>
    </div>
</div>