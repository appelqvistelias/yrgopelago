<?php
require_once __DIR__ . "/../../init.php";

// Check if user is already logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

try {
    $database = new PDO('sqlite:' . __DIR__ . '/../../database/bookings.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all bookings to display
    $statement = $database->prepare('SELECT bookings.id, bookings.first_name, bookings.last_name, bookings.start_date, bookings.end_date, bookings.total_cost, bookings.transfer_code, room_types.type as room_type, GROUP_CONCAT(features.name) as features FROM bookings LEFT JOIN room_types ON bookings.room_type_id = room_types.id LEFT JOIN booking_features ON bookings.id = booking_features.booking_id LEFT JOIN features ON booking_features.feature_id = features.id GROUP BY bookings.id ORDER BY bookings.id;');
    $statement->execute();
    $bookings = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    exit('Database error');
}

require_once __DIR__ . '/header.php';
?>

<main>
    <section id="admin-dashboard">
        <canvas id="matrix-drops"></canvas>
        <div class="admin-dashboard-container">
            <div class="top-container">
                <h1>Admin Dashboard</h1>
                <div class="admin-buttons">
                    <form method="post" action="../logic/clear_bookings.php">
                        <button type="submit" class="eight-bit-btn btn-red">Clear All</button>
                    </form>
                    <a href="../logic/logout.php" class="eight-bit-btn btn-red">Logout</a>
                </div>
            </div>
            <div class="bookings-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Guest</th>
                            <th>Room Type</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Features</th>
                            <th>Cost</th>
                            <th>Transfer Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>#<?= htmlspecialchars($booking['id']) ?></td>
                                <td><?= htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']) ?></td>
                                <td><?= htmlspecialchars($booking['room_type']) ?></td>
                                <td><?= htmlspecialchars($booking['start_date']) ?></td>
                                <td><?= htmlspecialchars($booking['end_date']) ?></td>
                                <td><?= htmlspecialchars($booking['features'] ?: 'None') ?></td>
                                <td>$<?= htmlspecialchars($booking['total_cost']) ?></td>
                                <td><?= htmlspecialchars($booking['transfer_code']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div> <!-- .bookings-table -->
        </div> <!-- .admin-dashboard-container -->
    </section> <!-- #admin-dashboard -->
</main>

<script src="../../assets/script/digital-rain-effect.js"></script>
</body>