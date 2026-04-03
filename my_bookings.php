<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get bookings
$result = $conn->query("SELECT bookings.id as booking_id, flights.flight_name, flights.source, flights.destination, flights.date, flights.price, bookings.seats_booked, bookings.status, bookings.created_at 
FROM bookings 
JOIN flights ON bookings.flight_id = flights.id
WHERE bookings.user_id = '$user_id' 
ORDER BY bookings.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings - Skywings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="dashboard-body">

<!-- Navbar -->
<div class="user-nav">
    <h2><i class="fa-solid fa-plane"></i> Skywings</h2>
    <div>
        <a href="dashboard.php"><i class="fa-solid fa-home"></i> Home</a>
        <a href="logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h1 class="page-title">
        <i class="fa-solid fa-ticket"></i> My Bookings
    </h1>
    
    <div class="bookings-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="booking-card">
                    <div class="booking-status <?php echo $row['status'] == 'Booked' ? 'status-booked' : 'status-cancelled'; ?>">
                        <?php echo $row['status']; ?>
                    </div>

                    <h3 class="flight-name">
                        <i class="fa-solid fa-plane"></i> <?php echo htmlspecialchars($row['flight_name']); ?>
                    </h3>

                    <p class="route">
                        <?php echo htmlspecialchars($row['source']); ?> → <?php echo htmlspecialchars($row['destination']); ?>
                    </p>

                    <p>Date: <?php echo date('d M Y', strtotime($row['date'])); ?></p>
                    <p>Seats: <?php echo $row['seats_booked']; ?></p>

                    <p class="flight-price">
                        ₹<?php echo number_format($row['price'] * $row['seats_booked']); ?>
                    </p>

                    <?php if ($row['status'] == 'Booked'): ?>
                        <button class="cancel-btn" onclick="cancelBooking(<?php echo $row['booking_id']; ?>)">
                            Cancel Booking
                        </button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:white;">No bookings found</p>
        <?php endif; ?>
    </div>

    <div class="back-link">
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</div>

<script>
function cancelBooking(id) {
    if(confirm("Cancel this booking?")) {
        window.location.href = "cancel.php?id=" + id;
    }
}
</script>

</body>
</html>