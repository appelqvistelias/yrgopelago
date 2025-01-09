<?php
require_once __DIR__ . "/init.php";

// Check if user is already logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/header.php';
?>

<main>
    <section id="admin-dashboard">
        <canvas id="matrix-drops"></canvas>
        <div class="admin-dashboard-container">
            <h1>Admin Dashboard</h1>

            <div>
                <a href="logout.php" class="eight-bit-btn btn-primary">Logout</a>
            </div>
        </div> <!-- .admin-dashboard-container -->
        </div> <!-- .admin-dashboard -->
    </section> <!-- #admin-dashboard -->
</main>

<script src="script/digital-rain-effect.js"></script>
</body>