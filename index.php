<?php
require_once __DIR__ . "/init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . "/booking.php";
    exit;
}

require_once __DIR__ . '/header.php';
?>

<main>
    <section id="hero">
        <div class="inner-wrapper">
            <h1>Welcome to the wonderful Back-End Hotel on Main Frame Island</h1>
        </div> <!-- .inner-wrapper -->
    </section> <!-- #hero -->

    <section id="info">
        <div class="inner-wrapper">
        </div> <!-- .inner-wrapper -->
    </section> <!-- #info -->

    <section id="booking">
        <div class="inner-wrapper">
            <form id="booking-form" method="post" action="index.php">
                <div class="arrival-departure">
                    <label for="startdate">Arrival:</label>
                    <input type="date" id="startdate" name="startdate" min="2025-01-01" max="2025-01-31" required>

                    <label for="enddate">Departure:</label>
                    <input type="date" id="enddate" name="enddate" min="2025-01-01" max="2025-01-31" required>
                </div> <!-- .arrival-departure -->

                <div class="room-selection">
                    <label for="room">Select room type:</label>
                    <select id="room" name="room" required>
                        <option value="" disabled selected>Room Type</option>
                        <option value="1" data-price="1">Economy $1/day</option>
                        <option value="2" data-price="2">Standard $2/day</option>
                        <option value="3" data-price="4">Luxury $4/day</option>
                    </select>

                    <div class="features-select">
                        <input type="checkbox" id="bathtub" name="features-options[]" value="1" data-price="1">
                        <label for="bathtub">Bathtub $1</label>

                        <input type="checkbox" id="pinball-game" name="features-options[]" value="2" data-price="2">
                        <label for="pinball-game">Pinball Game $2</label>

                        <input type="checkbox" id="sauna" name="features-options[]" value="3" data-price="3">
                        <label for="sauna">Sauna $3</label>
                    </div> <!-- .features-select -->
                </div> <!-- .room-selection -->

                <div class="booker">
                    <label for="firstname">First name:</label>
                    <input type="text" id="firstname" name="firstname" required>

                    <label for="lastname">Last name:</label>
                    <input type="text" id="lastname" name="lastname" required>

                    <label for="transferCode">Transfer Code:</label>
                    <input type="text" id="transferCode" name="transferCode" required>
                </div> <!-- .booker -->

                <div class="price">
                    <div>
                        <p>Room: </p>
                        <p class="room-price">$0</p>
                    </div>

                    <div>
                        <p>Features: </p>
                        <p class="features-price">$0</p>
                    </div>

                    <div>
                        <p>Total: </p>
                        <p class="total-price">$0</p>
                    </div>
                </div> <!-- .price -->

                <button type="submit">Submit</button>
            </form>
            <div class="user-feedback">
            </div> <!-- .user-feedback -->
        </div> <!-- .inner-wrapper -->
    </section> <!-- #booking -->
</main>

<?php
require_once(__DIR__ . '/footer.php');
?>