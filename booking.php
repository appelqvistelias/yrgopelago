<?php

declare(strict_types=1);

use GuzzleHttp\Exception\ClientException;

$S_SESSION['messages'] = []; // Store messages for user feedback

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

        // Checking if transfercode is valid
        if (isValidUuid($transferCode)) {
            try {
                $client = new GuzzleHttp\Client();

                // Checks if the transfercode and total cost match order
                $res = $client->request('POST', 'https://yrgopelago.se/centralbank/transferCode', [
                    'form_params' => [
                        'transferCode' => $transferCode,
                        'totalcost' => $totalCost
                    ]
                ]);

                // Convert raw API response data from json to PHP array
                $body = $res->getBody();
                $stringBody = (string) $body;
                $transferCodeResult = json_decode($stringBody, true);

                if (isset($transferCodeResult['status']) && $transferCodeResult['status'] === 'success') {
                    // Send data to the deposit endpoint to recieve payment
                    $res = $client->request('POST', 'https://yrgopelago.se/centralbank/deposit', [
                        'form_params' => [
                            'user' => 'elias',
                            'transferCode' => $transferCode
                        ]
                    ]);

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

                    $bookingId = $database->lastInsertId(); // Current booking ID

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

                    $_SESSION['messages'][] = "Your booking is successful! Your total is $totalCost.";
                }
            } catch (ClientException $e) {
                $response = $e->getResponse();
                $errorContent = $response->getBody()->getContents();

                $errorMessage = json_decode($errorContent, true);
                $_SESSION['messages'][] = $errorMessage['error'];
            }
        } else {
            echo "Invalid transfer code format.";
        }
    } else {
        echo "Invalid request method.";
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
