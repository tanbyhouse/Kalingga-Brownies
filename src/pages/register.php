<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require(BASE_PATH . '/src/core/database.php');

    // get data form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    $errors = [];

    // validasi
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    if ($password !== $password_confirm) {
        $errors[] = 'Passwords do not match.';
    }

    // cek email
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'An account with this email already exists.';
    }

    if (empty($errors)) {
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // insert new customer
        $stmt = $pdo->prepare(
            "INSERT INTO customers (name, email, password_hash) VALUES (?, ?, ?)"
        );
        $stmt->execute([$name, $email, $password_hash]);
        
        header('Location: index.php?page=login&registered=1');
        exit();
    }
}
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="w-full max-w-md space-y-8 bg-white rounded-lg shadow-xl p-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-yellow-900">
                Create a New Account
            </h2>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md">
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="index.php?page=register" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="name" class="sr-only">Full Name</label>
                    <input id="name" name="name" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" placeholder="Full Name">
                </div>
                <div>
                    <label for="email-address" class="sr-only">Email address</label>
                    <input id="email-address" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" placeholder="Email address">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" placeholder="Password (min. 8 characters)">
                </div>
                <div>
                    <label for="password_confirm" class="sr-only">Confirm Password</label>
                    <input id="password_confirm" name="password_confirm" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" placeholder="Confirm Password">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-800 hover:bg-yellow-900">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>