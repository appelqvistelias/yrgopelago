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
        <a href="logout.php" class="eight-bit-btn">Logout</a>
        </div> <!-- .admin-dashboard -->
    </section> <!-- #admin-dashboard -->
</main>

<script src="script/digital-rain-effect.js"></script>
</body>