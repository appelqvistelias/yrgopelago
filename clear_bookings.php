<?php
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
    $database->exec('DELETE FROM booking_features');
    $database->exec('DELETE FROM bookings');

    header('Location: admin.php');
    exit;
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    exit('Database error');
}
