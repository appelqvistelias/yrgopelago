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
                    <h2 class="welcome-text stars">★ ★ ★ ★ ★</h2>
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
            <div class="special-offer-flex-container">
                <p class="special-offer-text">Enjoy a 30% discount when you book a room for five days or more!</p>
                <div class="special-offer-btn">
                    <p>Book now!</p>
                    <div class="scroll-down-arrow"></div>
                </div> <!-- .special-offer-btn -->
            </div> <!-- .special-offer-flex-container -->
        </div> <!-- .inner-wrapper -->
    </div> <!-- .special-offer -->

    <section id="booking">
        <div class="inner-wrapper">
            <div class="booking-grid">
                <div class="calendar-container">
                    <h3>January 2025</h3>
                    <p class="available">Available</p>
                    <p class="booked">Occupied</p>
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
                    <h3>Book your stay</h3>
                    <form id="booking-form" method="post" action="index.php">
                        <div class="arrival-departure">
                            <div class="arrival">
                                <label for="startdate">Arrival</label>
                                <input type="date" id="startdate" name="startdate" min="2025-01-01" max="2025-01-31" required>
                            </div> <!-- .arrival -->
                            <div class="departure">
                                <label for="enddate">Departure</label>
                                <input type="date" id="enddate" name="enddate" min="2025-01-01" max="2025-01-31" required>
                            </div> <!-- .departure -->
                        </div> <!-- .arrival-departure -->

                        <div class="room-selection">
                            <label for="room">Select room</label>
                            <select id="room" name="room" required>
                                <option value="" disabled selected>Room Type</option>
                                <option value="1" data-price="1">Economy $1/day</option>
                                <option value="2" data-price="2">Standard $2/day</option>
                                <option value="3" data-price="4">Luxury $4/day</option>
                            </select>
                        </div> <!-- .room-selection -->

                        <div class="features-select">
                            <p>Additional features</p>
                            <div class="feature">
                                <input type="checkbox" class="checkboxes" id="bathtub" name="features-options[]" value="1" data-price="1">
                                <label for="bathtub">Bathtub $1</label>
                            </div> <!-- .feature -->
                            <div class="feature">
                                <input type="checkbox" class="checkboxes" id="pinball-game" name="features-options[]" value="2" data-price="2">
                                <label for="pinball-game">Pinball Game $2</label>
                            </div> <!-- .feature -->
                            <div class="feature">
                                <input type="checkbox" class="checkboxes" id="sauna" name="features-options[]" value="3" data-price="3">
                                <label for="sauna">Sauna $3</label>
                            </div> <!-- .feature -->
                        </div> <!-- .features-select -->

                        <div class="booker">
                            <div class="first-name">
                                <label for="firstname">First name:</label>
                                <input type="text" id="firstname" name="firstname" required>
                            </div>
                            <div class="last-name">
                                <label for="lastname">Last name:</label>
                                <input type="text" id="lastname" name="lastname" required>
                            </div>
                            <div class="transfer-code">
                                <label for="transferCode">Transfer Code:</label>
                                <input type="text" id="transferCode" name="transferCode" required>
                            </div>
                        </div> <!-- .booker -->

                        <div class="prices">
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
                            <button type="submit" class="eight-bit-btn btn-green">Submit</button>
                            <button type="reset" class="eight-bit-btn btn-red">Clear</button>
                        </div> <!-- .button-container -->
                    </form>

                    <div class="error-feedback">
                    </div> <!-- .error-message -->

                </div> <!-- .booking-form-container -->
            </div> <!-- .booking-grid -->
        </div> <!-- .inner-wrapper -->
    </section> <!-- #booking -->
</main>

<?php
require_once(__DIR__ . '/footer.php');
?>