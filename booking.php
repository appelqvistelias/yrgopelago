<?php

declare(strict_types=1);

header('Content-Type: application/json');

use GuzzleHttp\Exception\ClientException;

try {
    $database = new PDO('sqlite:database/bookings.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $startDate = new DateTime(sanitizeInput($_POST['startdate']));
        $endDate = new DateTime(sanitizeInput($_POST['enddate']));
        $selectedRoom = sanitizeInput($_POST['room']);
        $selectedFeatures = isset($_POST['features-options']) ? array_map('trim', $_POST['features-options']) : [];
        $firstName = sanitizeInput($_POST['firstname']);
        $lastName = sanitizeInput($_POST['lastname']);
        $transferCode = sanitizeInput($_POST['transferCode']);

        // Validate date range
        if ($startDate > $endDate || $startDate < new DateTime('2025-01-01') || $endDate > new DateTime('2025-01-31')) {
            http_response_code(400); // Bad Request
            echo json_encode([
                'status' => 'error',
                'message' => 'Start date cannot be after the end date or out of range.'
            ]);
            exit;
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

        // Adding discount
        if ($totalDays >= 5) {
            $totalCost = calculateDiscount($totalCost);
        }

        // Naming rooms for json-response
        $roomTypes = [1 => 'Economy', 2 => 'Standard', 3 => 'Luxury'];
        $roomType = $roomTypes[$selectedRoom] ?? 'Unknown Room';

        // Naming features for json-response
        $featuresNames = [
            1 => 'Bathtub',
            2 => 'Pinball Game',
            3 => 'Sauna'
        ];

        $selectedFeaturesNames = array_map(function ($featureId) use ($featuresNames) {
            return $featuresNames[$featureId] ?? 'Unknown feature';
        }, $selectedFeatures);

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
                    // Send data to the deposit endpoint to receive payment
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

                    http_response_code(200); // OK
                    echo json_encode([
                        'status' => 'success',
                        'data' => [
                            'island' => 'Main Frame Island',
                            'hotel' => 'Back-End Hotel',
                            'arrival_date' => $startDate->format('Y-m-d'),
                            'departure_date' => $endDate->format('Y-m-d'),
                            'total_cost' => $totalCost,
                            'stars' => 3,
                            'room_type' => $roomType,
                            'features' => $selectedFeaturesNames,
                            'additional_info' => [
                                'greetings' => 'Thank you for choosing Back-End Hotel!',
                                'gif_url' => 'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExdXQ2Ynh4MjlpMjFncWU0aHV2dHR2OHJ0aHkzYmJkNWY1MHZybmJkciZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/MC6eSuC3yypCU/giphy.gif',
                                'img' => '/images/neo.png'
                            ]
                        ]
                    ]);
                    exit;
                }
            } catch (ClientException $e) {
                $response = $e->getResponse();
                $errorContent = $response->getBody()->getContents();
                $errorMessage = json_decode($errorContent, true);
                http_response_code(400); // Bad Request
                echo json_encode([
                    'status' => 'error',
                    'message' => $errorMessage['error']
                ]);
                exit;
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid transfer code format.'
            ]);
            exit;
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request method.'
        ]);
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
    exit;
}
