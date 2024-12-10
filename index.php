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
                <label for="room">Select room type:</label>
                <select id="room" name="room" required>
                    <option value="economy">Economy</option>
                    <option value="standard">Standard</option>
                    <option value="luxury">Luxury</option>
                </select>

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