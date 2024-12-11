<?php
require_once(__DIR__ . '/header.php');
?>

<main>
    <section id="hero">
        <div class="inner-wrapper">
            <h1>Welcome to the wonderful hotel HOTEL-NAME on the island of ISLAND-NAME</h1>
        </div> <!-- .inner-wrapper -->
    </section> <!-- #hero -->

    <section id="info">
        <div class="inner-wrapper">
        </div> <!-- .inner-wrapper -->
    </section> <!-- #info -->

    <section id="booking">
        <div class="inner-wrapper">
            <form method="post" action="">
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
                        <option value="economy">Economy</option>
                        <option value="standard">Standard</option>
                        <option value="luxury">Luxury</option>
                    </select>

                    <div class="economy-select">
                        <input type="checkbox" id="television" name="economy-options[]" value="tv">
                        <label for="television">TV</label>

                        <input type="checkbox" id="waterboiler" name="economy-options[]" value="waterboiler">
                        <label for="waterboiler">Waterboiler</label>

                        <input type="checkbox" id="minibar" name="economy-options[]" value="minibar">
                        <label for="minibar">Minibar</label>
                    </div> <!-- .economy-select -->

                    <div class="standard-select">
                        <input type="checkbox" id="coffemaker" name="standard-options[]" value="coffemaker">
                        <label for="coffemaker">Coffemaker</label>

                        <input type="checkbox" id="bathtub" name="standard-options[]" value="bathtub">
                        <label for="bathtub">Bathtub</label>

                        <input type="checkbox" id="yatzy" name="standard-options[]" value="yatzy">
                        <label for="yatzy">Yatzy</label>
                    </div> <!-- .standard-select -->

                    <div class="luxury-select">
                        <input type="checkbox" id="sauna" name="luxury-options[]" value="sauna">
                        <label for="sauna">Sauna</label>

                        <input type="checkbox" id="ps5" name="luxury-options[]" value="ps5">
                        <label for="ps5">PlayStation 5</label>

                        <input type="checkbox" id="pinball-game" name="luxury-options[]" value="pinball-game">
                        <label for="pinball-game">Pinball Game</label>
                    </div> <!-- .luxury-select -->
                </div> <!-- .room-selection -->

                <div class="booker">
                    <label for="firstname">First name:</label>
                    <input type="text" id="firstname" name="firstname" required>

                    <label for="lastname">Last name:</label>
                    <input type="text" id="lastname" name="lastname" required>

                    <label for="transfer-code">Transfer Code:</label>
                    <input type="text" id="transfer-code" name="transfer-code" required>
                </div> <!-- .booker -->

                <div class="price">
                    <div>
                        <p>Room: </p>
                        <p class="room-price"></p>
                    </div>

                    <div>
                        <p>Features: </p>
                        <p class="features-price"></p>
                    </div>

                    <div>
                        <p>Total: </p>
                        <p class="total-price"></p>
                    </div>
                </div> <!-- .price -->

                <button type="submit">Submit</button>
            </form>
        </div> <!-- .inner-wrapper -->
    </section> <!-- #booking -->
</main>

<?php
require_once(__DIR__ . '/footer.php');
?>