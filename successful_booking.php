<?php
require_once __DIR__ . "/init.php";

$island = htmlspecialchars($_GET['island']);
$hotel = htmlspecialchars($_GET['hotel']);
$arrival_date = htmlspecialchars($_GET['arrival_date']);
$departure_date = htmlspecialchars($_GET['departure_date']);
$total_cost = htmlspecialchars($_GET['total_cost']);
$stars = htmlspecialchars($_GET['stars']);
$room_type = htmlspecialchars($_GET['room_type']);
$features = htmlspecialchars($_GET['features']);
$greetings = htmlspecialchars($_GET['greetings']);
$gif_url = htmlspecialchars($_GET['gif_url']);

require_once __DIR__ . '/header.php';
?>

<main>
    <section id="successful-booking">
        <canvas id="matrix-drops"></canvas>
        <div class="success-feedback">
            <div>
                <h2>Booking Successful!</h2>
                <p>Island Name: <?= $island ?></p>
                <p>Hotel Name: <?= $hotel ?></p>
                <p>Arrival Date: <?= $arrival_date ?></p>
                <p>Departure Date: <?= $departure_date ?></p>
                <p>Total Cost: $<?= $total_cost ?></p>
                <p>Stars: <?= $stars ?></p>
                <p>Room Type: <?= $room_type ?></p>
                <p>Features: <?= $features ?></p>
                <p><?= $greetings ?></p>
            </div>
            <img class="success-gif" src="<?= $gif_url ?>" alt="Success GIF">
            <div class="back-to-index-btn">
                <a href="index.php" class="eight-bit-btn btn-green">Back</a>
            </div> <!-- back-to-index-btn -->
        </div> <!-- success-feedback -->
    </section> <!-- successful-booking -->
</main>

<script src="script/digital-rain-effect.js"></script>
</body>