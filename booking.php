<?php
try {
    $database = new PDO('sqlite:database/bookings.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $startDate = new DateTime(trim(htmlspecialchars($_POST['startdate'])));
        $endDate = new DateTime(trim(htmlspecialchars($_POST['enddate'])));
        $selectedRoom = trim(htmlspecialchars($_POST['room']));
        $selectedFeatures = isset($_POST['features-options']) ? array_map('trim', $_POST['features-options']) : [];
        $firstName = trim(htmlspecialchars($_POST['firstname']));
        $lastName = trim(htmlspecialchars($_POST['lastname']));
        $transferCode = trim(htmlspecialchars($_POST['transferCode']));

        // Validate date range
        if ($startDate > $endDate || $startDate < new DateTime('2025-01-01') || $endDate > new DateTime('2025-01-31')) {
            throw new Exception("Invalid date range selected.");
        }

        // Add booking to the bookings table
        $statement = $database->prepare('INSERT INTO bookings (first_name, last_name, start_date, end_date, room_type_id, transfer_code) VALUES (:firstName, :lastName, :startDate, :endDate, :roomTypeId, :transferCode)');
        $statement->bindParam(':firstName', $firstName);
        $statement->bindParam(':lastName', $lastName);
        $statement->bindValue(':startDate', $startDate->format('Y-m-d'));
        $statement->bindValue(':endDate', $endDate->format('Y-m-d'));
        $statement->bindValue(':roomTypeId', $selectedRoom);
        $statement->bindParam(':transferCode', $transferCode);
        $statement->execute();

        $bookingId = $database->lastInsertId();

        // Array connecting features to booking ID
        $bookedFeatures = [];
        $featuresInsert = "";

        foreach ($selectedFeatures as $feature) {
            $bookedFeatures[] = ['booking_id' => $bookingId, 'feature' => $feature];
        }

        foreach ($bookedFeatures as $insert) {
            $query = "INSERT INTO booking_features (booking_id, feature_id) VALUES (:featuresInsert)";
            $featuresInsert = $featuresInsert .=  $insert['booking_id'] .  ", " . $insert['feature'];
        }

        $statement = $database->prepare($query);
        $statement->bindParam(':featuresInsert', $featuresInsert);
        $statement->execute();

        echo "Booking successfully saved! Total cost: $totalCost.";
    } else {
        echo "Invalid request method.";
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

// See if transferCode is valid
function isValidUuid(string $uuid): bool
{

    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }

    return true;
}

// if (isset($transferCode, $totalCost)) {
// $transferData = json_decode(file_get_contents(__DIR__ . '/guests/guests.json'), true);

// $transferData[] = [
// 'trasfercode' => $transferCode,
// 'transfercost' => $totalCost
// ];

// $transferData = json_encode($transferData);
// file_put_contents(__DIR__ . '/guests/guests.json', $transferData);

// header('Content-Type: application/json');

// echo $transferData;
// }