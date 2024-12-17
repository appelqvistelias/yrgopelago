<?php

declare(strict_types=1);

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
        $bookingId = $database->lastInsertId(); // Current booking ID

        // Validate date range
        if ($startDate > $endDate || $startDate < new DateTime('2025-01-01') || $endDate > new DateTime('2025-01-31')) {
            throw new Exception("Invalid date range selected.");
        }

        // Calculate total number of days
        $dateDifference = $startDate->diff($endDate);
        $totalDays = $dateDifference->days + 1;

        // Calculate total cost
        $totalCost = 0;

        for ($i = 0; $i < $totalDays; $i++) {
            if ($selectedRoom == 1) {
                $totalCost += 1;
            } elseif ($selectedRoom == 2) {
                $totalCost += 2;
            } elseif ($selectedRoom == 3) {
                $totalCost += 4;
            }
        }

        foreach ($selectedFeatures as $feature) {
            if ($feature == 1) {
                $totalCost += 1;
            } elseif ($feature == 2) {
                $totalCost += 2;
            } elseif ($feature == 3) {
                $totalCost += 3;
            }
        }

        // Add booking to the bookings table
        $statement = $database->prepare('INSERT INTO bookings (first_name, last_name, start_date, end_date, room_type_id, total_cost, transfer_code) VALUES (:firstName, :lastName, :startDate, :endDate, :roomTypeId, :totalCost, :transferCode)');
        $statement->bindParam(':firstName', $firstName);
        $statement->bindParam(':lastName', $lastName);
        $statement->bindValue(':startDate', $startDate->format('Y-m-d'));
        $statement->bindValue(':endDate', $endDate->format('Y-m-d'));
        $statement->bindValue(':roomTypeId', $selectedRoom);
        $statement->bindParam(':totalCost', $totalCost);
        $statement->bindParam(':transferCode', $transferCode);
        $statement->execute();

        // Connecting features to booking ID
        $bookedFeatures = [];

        foreach ($selectedFeatures as $feature) {
            $bookedFeatures[] = ['booking_id' => $bookingId, 'feature' => $feature];
        }

        $statement = $database->prepare('INSERT INTO booking_features (booking_id, feature_id) VALUES (:bookingId, :featureId);');

        foreach ($bookedFeatures as $booking) {
            $statement->bindParam(':bookingId', $booking['booking_id']);
            $statement->bindParam(':featureId', $booking['feature']);
            $statement->execute();
        }

        echo "Booking successfully saved! Your total is $totalCost.";
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
