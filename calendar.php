<?php

declare(strict_types=1);

header('Content-Type: application/json');

try {
    $database = new PDO('sqlite:database/bookings.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $database->prepare("SELECT start_date, end_date, room_type_id FROM bookings");
    $statement->execute();

    $bookedDates = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $startDate = new DateTime($row['start_date']);
        $endDate = new DateTime($row['end_date']);
        $roomTypeId = $row['room_type_id'];

        while ($startDate <= $endDate) {
            $bookedDates[] = ['date' => $startDate->format('Y-m-d'), 'roomType' => $roomTypeId];
            $startDate->modify('+1 day');
        }
    }
    echo json_encode($bookedDates);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
