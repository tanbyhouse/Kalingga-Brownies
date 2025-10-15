<?php
require(BASE_PATH . '/src/core/database.php');

// Featured product for hero (first product)
$featured_product = $pdo->query("SELECT * FROM products ORDER BY id ASC LIMIT 1")->fetch();

// hero categories
$categories_stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $categories_stmt->fetchAll();

// latest products for grid
$products_stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 12");
$products = $products_stmt->fetchAll();
?>

<section class="relative h-[calc(100vh-6rem)] md:h-[calc(100vh-7rem)] bg-creamy-bg">
    <div class="absolute inset-0">
        <?php if ($featured_product): ?>
            <img src="<?php echo htmlspecialchars($featured_product['image_url'] ?: 'https://via.placeholder.com/1920x1080/FED7AA/78350F?text=Hero'); ?>" alt="<?php echo htmlspecialchars($featured_product['name']); ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <img src="https://via.placeholder.com/1920x1080/FED7AA/78350F?text=Hero+Video+or+Image" alt="Hero" class="w-full h-full object-cover">
        <?php endif; ?>
    </div>

    <div class="absolute inset-0 flex items-center justify-center p-4 z-10">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-5xl h-full max-h-[65vh] flex flex-col">
            <div class="flex-grow overflow-y-auto">
                <?php if ($featured_product): ?>
                    <div class="p-8 md:p-12 grid md:grid-cols-2 gap-6 items-center">
                        <div>
                            <h1 class="text-4xl md:text-5xl font-serif font-bold text-brand-brown mb-4"><?php echo htmlspecialchars($featured_product['name']); ?></h1>
                            <p class="text-lg text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($featured_product['description'])); ?></p>
                            <div class="text-2xl font-bold text-yellow-800 mb-4">Rp <?php echo number_format($featured_product['price'], 0, ',', '.'); ?></div>
                            <a href="index.php?page=products-detail&id=<?php echo urlencode($featured_product['id']); ?>" class="inline-block bg-red-900 hover:bg-red-950 text-white font-bold py-3 px-6 rounded-lg transition duration-300">View product</a>
                        </div>
                        <div class="">
                            <img src="<?php echo htmlspecialchars($featured_product['image_url'] ?: 'https://via.placeholder.com/800x500'); ?>" alt="<?php echo htmlspecialchars($featured_product['name']); ?>" class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg">
                        </div>
                    </div>
                <?php else: ?>
                    <img src="https://image.pngaaa.com/13/1887013-middle.png" alt="No image added yet" class="w-full object-cover">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="bg-brand-brown py-20 md:py-32 text-center text-creamy-bg">
    <div class="container mx-auto px-6">
        <p class="text-xl md:text-3xl font-serif leading-relaxed mb-4 tracking-wide">
            "SOME DAYS & THE FEELINGS THEY BRING TAKE TIME TO UNWRAP, BUT BROWNIES SHOULDN'T BE ONE OF THEM."
        </p>
    </div>
</section>

<!-- Products grid -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-serif font-bold text-center mb-8">Latest Products</h2>
        <?php if (!empty($products)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($products as $p): ?>
                    <div class="border rounded-lg overflow-hidden shadow-sm bg-white">
                        <a href="index.php?page=products-detail&id=<?php echo urlencode($p['id']); ?>">
                            <img src="<?php echo htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/400x300'); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2"><a class="hover:underline" href="index.php?page=products-detail&id=<?php echo urlencode($p['id']); ?>"><?php echo htmlspecialchars($p['name']); ?></a></h3>
                            <div class="text-yellow-800 font-bold mb-2">Rp <?php echo number_format($p['price'], 0, ',', '.'); ?></div>
                            <p class="text-sm text-gray-600 line-clamp-3 mb-3"><?php echo htmlspecialchars(substr($p['description'], 0, 120)); ?><?php echo (strlen($p['description'])>120)?'...':''; ?></p>
                            <div class="flex items-center justify-between">
                                <a href="index.php?page=products-detail&id=<?php echo urlencode($p['id']); ?>" class="text-sm text-red-900 font-semibold">View</a>
                                <form method="post" action="index.php?page=cart-add">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($p['id']); ?>">
                                    <button type="submit" class="bg-red-900 text-white px-3 py-1 rounded text-sm">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No products found.</p>
        <?php endif; ?>
    </div>
</section>