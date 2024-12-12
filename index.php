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

    <?php if (isset($_POST)) {
        var_dump($_POST);

        $startDate = new DateTime(trim(htmlspecialchars($_POST['startdate'])));
        $endDate = new DateTime(trim(htmlspecialchars($_POST['enddate'])));
        $selectedRoom = trim(htmlspecialchars($_POST['room']));
        $selectedFeatures = $_POST['features-options'];
        $firstName = trim(htmlspecialchars($_POST['firstname']));
        $lastName = trim(htmlspecialchars($_POST['lastname']));
        $transferCode = trim(htmlspecialchars($_POST['transferCode']));

        $totalCost = 0;

        if ($selectedRoom === 'economy') {
            $totalCost = 1;
        } elseif ($selectedRoom === 'standard') {
            $totalCost = 2;
        } elseif ($selectedRoom === 'luxury') {
            $totalCost = 4;
        }

        // if (isset($transferCode, $totalCost)) {
        //     $transferData = json_decode(file_get_contents(__DIR__ . '/guests/guests.json'), true);

        //     $transferData[] = [
        //         'trasfercode' => $transferCode,
        //         'transfercost' => $totalCost
        //     ];

        //     $transferData = json_encode($transferData);
        //     file_put_contents(__DIR__ . '/guests/guests.json', $transferData);

        //     header('Content-Type: application/json');

        //     echo $transferData;
        // }
    } ?>

    <section id="booking">
        <div class="inner-wrapper">
            <form method="post" action="index.php">
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
                        <option value="economy" data-price="1">Economy</option>
                        <option value="standard" data-price="2">Standard</option>
                        <option value="luxury" data-price="4">Luxury</option>
                    </select>

                    <div class="features-select">
                        <input type="checkbox" id="bathtub" name="features-options[]" value="bathtub" data-price="1">
                        <label for="bathtub">Bathtub</label>

                        <input type="checkbox" id="pinball-game" name="features-options[]" value="pinball-game" data-price="2">
                        <label for="pinball-game">Pinball Game</label>

                        <input type="checkbox" id="sauna" name="features-options[]" value="sauna" data-price="3">
                        <label for="sauna">Sauna</label>
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
                        <p class="room-price">0</p>
                    </div>

                    <div>
                        <p>Features: </p>
                        <p class="features-price">0</p>
                    </div>

                    <div>
                        <p>Total: </p>
                        <p class="total-price">0</p>
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