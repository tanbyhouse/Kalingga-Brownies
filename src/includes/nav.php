<nav class="bg-oil shadow-lg">
    <div class="container mx-auto px-6 py-3">
        <div class="flex justify-between items-center">
        <div>
            <a href="index.php?page=home" class="text-white text-2xl font-bold hover:text-pink-200">
            Kalingga Brownies
            </a>
        </div>
        <div class="hidden md:flex items-center space-x-6">
            <a href="index.php?page=home" class="text-white hover:text-pink-200">Home</a>
            <a href="index.php?page=products" class="text-white hover:text-pink-200">Our Brownies</a>
            
            <?php if (isset($_SESSION['user_role'])): ?>
            
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="index.php?page=admin-dashboard" class="text-white font-bold bg-red-600 px-3 py-1 rounded">Admin Dashboard</a>
            <?php else: ?>
                <a href="index.php?page=my-account" class="text-white hover:text-pink-200">My Account</a>
            <?php endif; ?>
            
            <a href="index.php?page=logout" class="text-white hover:text-pink-200">Logout</a>
            
        <?php else: ?>
            <a href="index.php?page=login" class="text-white bg-pink-500 hover:bg-pink-600 px-4 py-2 rounded-md transition duration-300">Login</a>
            <a href="index.php?page=register" class="text-white hover:text-pink-200">Register</a>
        <?php endif; ?>
        
        </div>
        </div>
    </div>
</nav>