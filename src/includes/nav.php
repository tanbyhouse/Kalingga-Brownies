<nav class="sticky top-0 z-30 bg-red-950 bg-opacity-80 py-4 backdrop-blur-md shadow">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="text-white text-2xl font-serif tracking-widest">KALINGGA BROWNIES</div>

        <div class="hidden md:flex space-x-8 text-white text-lg">
            <a href="index.php?page=about" class="hover:text-red-200">HOME</a>
            <a href="index.php?page=products" class="hover:text-red-200">OUR BROWNIES</a>
        </div>
        
        <div class="text-white text-lg">
            <a href="#" class="hover:text-red-200">CART (0)</a>
        </div>

        <?php if (isset($_SESSION['user_role'])): ?>
            
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="index.php?page=admin-dashboard" class="text-white font-bold bg-red-600 px-3 py-1 rounded">Admin Dashboard</a>
            <?php else: ?>
                <a href="index.php?page=my-account" class="text-white hover:text-red-200">My Account</a>
            <?php endif; ?>
            
            <a href="index.php?page=logout" class="text-white hover:text-red-200">Logout</a>
            
        <?php else: ?>
            <a href="index.php?page=login" class="text-red-900 bg-red-100 hover:bg-red-300 px-4 py-2 rounded-lg transition duration-300">Login</a>
        <?php endif; ?>
    </div>
</nav>