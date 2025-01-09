<?php

declare(strict_types=1);
require_once __DIR__ . "/init.php";

// Check if user is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

try {
    $database = new PDO('sqlite:' . __DIR__ . '/database/bookings.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Clear bookings and booking_features tables
    $database->exec('DROP TABLE bookings;');
    $database->exec('DROP TABLE booking_features;');

    $database->exec('CREATE TABLE IF NOT EXISTS bookings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        room_type_id INTEGER NOT NULL,
        total_cost INTEGER NOT NULL,
        transfer_code TEXT NOT NULL,
        
        FOREIGN KEY (room_type_id) REFERENCES room_types(id)
        );');

    $database->exec('CREATE TABLE IF NOT EXISTS booking_features (
        booking_id INTEGER NOT NULL,
        feature_id INTEGER NOT NULL,
        PRIMARY KEY (booking_id, feature_id),
        
        FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
        FOREIGN KEY (feature_id) REFERENCES features(id) ON DELETE CASCADE
        );');

    header('Location: admin.php');
    exit;
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    exit('Database error');
}
