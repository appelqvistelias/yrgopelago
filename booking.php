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

        $statement = $database->prepare("SELECT id FROM room_types WHERE type = :roomType");
        $statement->bindParam(':roomType', $selectedRoom, PDO::PARAM_STR);
        $statement->execute();
        $roomTypeId = $statement->fetchColumn();

        if (!$roomTypeId) {
            throw new Exception("Invalid room type selected.");
        }

        $statement = $database->prepare('INSERT INTO bookings (first_name, last_name, start_date, end_date, room_type_id, transfer_code) VALUES (:firstName, :lastName, :startDate, :endDate, :roomTypeId, :transferCode)');
        $statement->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $statement->bindValue(':startDate', $startDate->format('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(':endDate', $endDate->format('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(':roomTypeId', $roomTypeId, PDO::PARAM_INT);  // Ensure valid room type ID
        $statement->bindParam(':transferCode', $transferCode, PDO::PARAM_STR);
        $statement->execute();

        $bookingId = $database->lastInsertId();

        foreach ($selectedFeatures as $feature) {
            $statement = $database->prepare("SELECT id, price FROM features WHERE name = :featureName");
            $statement->bindParam(':featureName', $feature, PDO::PARAM_STR);
            $statement->execute();
            $featureResult = $statement->fetch(PDO::FETCH_ASSOC);

            if ($featureResult) {
                $statement = $database->prepare('INSERT INTO booking_features (booking_id, feature_id) VALUES (:bookingId, :featureId)');
                $statement->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
                $statement->bindParam(':featureId', $featureResult['id'], PDO::PARAM_INT);
                $statement->execute();

                $totalCost += $featureResult['price'];
            }
        }

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