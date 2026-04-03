<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];

// First get booking details
$stmt = $conn->prepare("SELECT flight_id, seats_booked, user_id FROM bookings WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

// Verify that the booking belongs to the logged-in user
if ($booking && $booking['user_id'] == $_SESSION['user_id']) {
    // Add seats back to flights
    $stmt2 = $conn->prepare("UPDATE flights SET seats = seats + ? WHERE id = ?");
    $stmt2->bind_param("ii", $booking['seats_booked'], $booking['flight_id']);
    $stmt2->execute();
    
    // Update booking status
    $stmt3 = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
    $stmt3->bind_param("i", $id);
    $stmt3->execute();
    
    header("Location: my_bookings.php?msg=cancelled");
    exit();
} else {
    echo "<script>alert('Booking not found or unauthorized!'); window.location.href='my_bookings.php';</script>";
}
?>