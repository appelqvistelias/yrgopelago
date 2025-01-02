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
        <canvas id="matrix-drops"></canvas>
        <div class="inner-wrapper">
            <h1>Welcome to the wonderful Back-End Hotel on Mainframe Island</h1>
        </div> <!-- .inner-wrapper -->
    </section> <!-- #hero -->

    <section id="info">
        <div class="inner-wrapper">
            <h2>Our rooms</h2>
            <div class="rooms-container">
                <img src="images/economy.png" alt="economy room">
                <img src="images/standard.png" alt="standard room">
            </div> <!-- .rooms-container -->
        </div> <!-- .inner-wrapper -->
    </section> <!-- #info -->

    <div class="special-offer">
        <p>Book a room for five or more days and get a 30% discount!</p>
    </div> <!-- .special-offer -->

    <section id="booking">
        <div class="inner-wrapper">
            <div class="calendar-container">
                <h3>January 2025</h3>
                <div class="calendar-grid">
                    <div class="weekday">Mon</div>
                    <div class="weekday">Tue</div>
                    <div class="weekday">Wed</div>
                    <div class="weekday">Thu</div>
                    <div class="weekday">Fri</div>
                    <div class="weekday">Sat</div>
                    <div class="weekday">Sun</div>
                </div> <!-- .calendar-grid -->
            </div> <!-- .calendar-container -->

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

                <button type="submit" class="eight-bit-btn btn-primary">Submit</button>
            </form>
            <div class=" user-feedback">
            </div> <!-- .user-feedback -->
        </div> <!-- .inner-wrapper -->
    </section> <!-- #booking -->
</main>

<?php
require_once(__DIR__ . '/footer.php');
?>