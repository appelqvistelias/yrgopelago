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
            <div class="hero-flex-container">
                <div class="welcome-sequence">
                    <h2 class="welcome-text">Initializing welcome sequence...</h2>
                    <h2 class="welcome-text">System status: Online</h2>
                    <h2 class="welcome-text">Accessing digital paradise...</h2>
                    <h2 class="welcome-text">Welcome, user</h2>
                    <h2 class="welcome-text">to</h2>
                    <h1 class="hotel-name">The Back-End Hotel</h1>
                </div> <!-- .welcome-sequence -->
                <div class="scroll-down">
                    <p>Scroll down to book your stay</p>
                    <div class="scroll-down-arrow"></div>
                </div> <!-- .scroll-down -->
            </div> <!-- .hero-flex-container -->
        </div> <!-- .inner-wrapper -->
    </section> <!-- #hero -->

    <section id="room-info">
        <div class="rooms-container">
            <div class="room" id="economy-room">
                <div class="room-text">
                    <h2 class="economy-room-text">Economy</h2>
                    <p class="economy-room-text">Perfect for budget-conscious travelers</p>
                </div> <!-- .room-text -->
            </div> <!-- .room #economy-room -->

            <div class="room" id="standard-room">
                <div class="room-text">
                    <h2 class="standard-room-text">Standard</h2>
                    <p class="standard-room-text">Ideal when comfort is your priority</p>
                </div> <!-- .room-text -->
            </div> <!-- .room #standard-room -->

            <div class="room" id="luxury-room">
                <div class="room-text">
                    <h2 class="luxury-room-text">Luxury</h2>
                    <p class="luxury-room-text">The ultimate indulgence with no compromises</p>
                </div> <!-- .room-text -->
            </div> <!-- .room #luxury-room -->
        </div> <!-- .rooms-container -->
    </section> <!-- #room-info -->

    <div class="special-offer">
        <div class="inner-wrapper">
            <p class="special-offer-text">Enjoy a 30% discount when you book a room for five days or more!</p>
        </div> <!-- .inner-wrapper -->
    </div> <!-- .special-offer -->

    <section id="booking">
        <div class="inner-wrapper">
            <div class="booking-grid">
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

                <div class="booking-form-container">
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

                        <div class="button-container">
                            <button type="submit" class="eight-bit-btn btn-submit">Submit</button>
                            <button type="reset" class="eight-bit-btn btn-clear">Clear</button>
                        </div> <!-- .button-container -->
                    </form>
                    <div class=" user-feedback">
                    </div> <!-- .user-feedback -->
                </div> <!-- .booking-form-container -->
            </div> <!-- .booking-grid -->
        </div> <!-- .inner-wrapper -->
    </section> <!-- #booking -->
</main>

<?php
require_once(__DIR__ . '/footer.php');
?>