<?php
require_once(__DIR__ . '/header.php');
?>

<main>
    <div class="inner-wrapper">
        <section id="hero">
            <h1>Welcome to the wonderful hotel HOTEL-NAME on the island of ISLAND-NAME</h1>
        </section> <!-- #hero -->

        <section id="info">

        </section> <!-- #info -->

        <section id="booking">
            <form method="post" action="">
                <div class="room-selection">
                    <label for="room">Select room type:</label>
                    <select id="room" name="room" required>
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

                </div>
                <label for="startdate">Start date:</label>
                <input type="date" id="startdate" name="startdate" min="2025-01-01" max="2025-01-31" required>

                <label for="enddate">End date:</label>
                <input type="date" id="enddate" name="enddate" min="2025-01-01" max="2025-01-31" required>

                <label for="firstname">First name:</label>
                <input type="text" id="firstname" name="firstname" required>

                <label for="lastname">Last name:</label>
                <input type="text" id="lastname" name="lastname" required>

                <button type="submit">Submit</button>
            </form>
        </section> <!-- #booking -->
    </div> <!-- .inner-wrapper -->
</main>

<?php
require_once(__DIR__ . '/footer.php');
?>