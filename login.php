<?php
require_once __DIR__ . "/init.php";

// Check if user is already logged in
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    if ($username === $_ENV['USER'] && $password === $_ENV['API_KEY']) {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}

require_once __DIR__ . '/header.php';
?>

<main>
    <section id="login">
        <canvas id="matrix-drops"></canvas>
        <div class="admin-login">
            <h2>Admin Login</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error; ?></p>
            <?php endif; ?>

            <form method="post" action="login.php" autocomplete="off">
                <div class="login-input">
                    <div>
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required autocomplete="username">
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="login-btn">
                        <button type="submit" class="eight-bit-btn btn-green">Login</button>
                    </div>
                </div> <!-- .login-input -->
            </form>
            <div class="exit-btn">
                <a href="index.php" class="eight-bit-btn btn-red">Exit</a>
            </div> <!-- .exit-btn -->
        </div> <!-- .admin-login -->
    </section> <!-- #login -->
</main>

<script src="assets/script/digital-rain-effect.js"></script>
</body>