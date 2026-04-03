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

$user_id   = $_SESSION['user_id'];
$flight_id = $_POST['flight_id'];
$seats     = $_POST['seats'];

$stmt = $conn->prepare("SELECT seats FROM flights WHERE id = ?");
$stmt->bind_param("i", $flight_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row && $row['seats'] >= $seats) {
    $stmt2 = $conn->prepare("UPDATE flights SET seats = seats - ? WHERE id = ?");
    $stmt2->bind_param("ii", $seats, $flight_id);
    $stmt2->execute();
    
    $created_at = date('Y-m-d H:i:s');
    $stmt3 = $conn->prepare("INSERT INTO bookings(user_id, flight_id, seats_booked, status, created_at) VALUES(?, ?, ?, 'Booked', ?)");
    $stmt3->bind_param("iiis", $user_id, $flight_id, $seats, $created_at);
    $stmt3->execute();
    
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Booking Confirmed - Skywings</title>
        <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .confirmation-box {
                background: white;
                padding: 40px;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0 20px 40px rgba(0,0,0,0.2);
                max-width: 500px;
                margin: 20px;
            }
            .success-icon {
                font-size: 80px;
                color: #2ecc71;
                margin-bottom: 20px;
            }
            h2 {
                color: #2ecc71;
                margin-bottom: 15px;
            }
            p {
                color: #666;
                margin: 10px 0;
            }
            .btn {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 30px;
                background: #ff4b2b;
                color: white;
                text-decoration: none;
                border-radius: 8px;
                margin: 10px;
                transition: background 0.3s;
            }
            .btn:hover {
                background: #e63e1f;
            }
            .btn-secondary {
                background: #3498db;
            }
            .btn-secondary:hover {
                background: #2980b9;
            }
        </style>
    </head>
    <body>
        <div class='confirmation-box'>
            <div class='success-icon'>
                <i class='fa-solid fa-circle-check'></i>
            </div>
            <h2>Ticket Booked Successfully! ✅</h2>
            <p>Your flight has been confirmed.</p>
            <p>You can view your booking details in 'My Bookings'.</p>
            <a href='dashboard.php' class='btn'><i class='fa-solid fa-home'></i> Back to Dashboard</a>
            <a href='my_bookings.php' class='btn btn-secondary'><i class='fa-solid fa-ticket'></i> View My Bookings</a>
        </div>
    </body>
    </html>";
} else {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Booking Failed - Skywings</title>
        <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .error-box {
                background: white;
                padding: 40px;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0 20px 40px rgba(0,0,0,0.2);
                max-width: 500px;
                margin: 20px;
            }
            .error-icon {
                font-size: 80px;
                color: #e74c3c;
                margin-bottom: 20px;
            }
            h2 {
                color: #e74c3c;
                margin-bottom: 15px;
            }
            p {
                color: #666;
                margin: 10px 0;
            }
            .btn {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 30px;
                background: #ff4b2b;
                color: white;
                text-decoration: none;
                border-radius: 8px;
                transition: background 0.3s;
            }
            .btn:hover {
                background: #e63e1f;
            }
        </style>
    </head>
    <body>
        <div class='error-box'>
            <div class='error-icon'>
                <i class='fa-solid fa-circle-exclamation'></i>
            </div>
            <h2>Not Enough Seats ❌</h2>
            <p>Sorry, the requested number of seats is not available.</p>
            <a href='dashboard.php' class='btn'>Back to Dashboard</a>
        </div>
    </body>
    </html>";
}
?>