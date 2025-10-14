<?php
require(BASE_PATH . '/src/core/database.php');

// get product id
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: index.php?page=products');
    exit();
}

// fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    require(BASE_PATH . '/src/pages/404.php');
    exit();
}
?>

<div class="container mx-auto p-4 md:p-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden md:flex">
        <div class="md:w-1/2">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
        </div>

        <div class="md:w-1/2 p-8 flex flex-col justify-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-900 mb-4"><?= htmlspecialchars($product['name']) ?></h1>
            
            <p class="text-gray-700 text-lg mb-6">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            </p>
            
            <div class="text-4xl font-bold text-pink-500 mb-8">
                Rp <?= number_format($product['price'], 0, ',', '.') ?>
            </div>

            <div class="mt-auto">
                <a href="#" class="w-full block text-center bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg text-xl transition duration-300">
                    Order via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>