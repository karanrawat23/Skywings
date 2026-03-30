<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all bookings for the user
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        body {
    background: url('images/dashboard-bg.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
}
        
        .navbar {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar h2 {
            color: #60f106;
        }
        
        .navbar h2 i {
            margin-right: 10px;
        }
        
        .navbar a {
            color: white;
            margin-left: 25px;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .navbar a:hover {
            color: #ff4b2b;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .page-title {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            font-size: 36px;
        }
        
        .page-title i {
            margin-right: 15px;
        }
        
        .bookings-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }
        
        .booking-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            width: 350px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s;
            position: relative;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
        }
        
        .booking-status {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-booked {
            background: #2ecc71;
            color: white;
        }
        
        .status-cancelled {
            background: #e74c3c;
            color: white;
        }
        
        .flight-name {
            font-size: 22px;
            color: #1e3c72;
            margin-bottom: 15px;
        }
        
        .flight-name i {
            margin-right: 10px;
            color: #ff4b2b;
        }
        
        .route {
            font-size: 18px;
            font-weight: bold;
            color: #ff4b2b;
            margin: 10px 0;
        }
        
        .detail {
            color: #666;
            margin: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .detail i {
            width: 20px;
            color: #ff4b2b;
        }
        
        .price {
            font-size: 24px;
            font-weight: bold;
            color: #2ecc71;
            margin: 15px 0;
        }
        
        .cancel-btn {
            width: 100%;
            padding: 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            transition: background 0.3s;
        }
        
        .cancel-btn:hover {
            background: #c0392b;
        }
        
        .cancel-btn.disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }
        
        .no-bookings {
            text-align: center;
            color: white;
            padding: 60px;
        }
        
        .no-bookings i {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 40px;
        }
        
        .back-link a {
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .back-link a:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>

<div class="navbar">
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
                    <div class="flight-name">
                        <i class="fa-solid fa-plane"></i> <?php echo htmlspecialchars($row['flight_name']); ?>
                    </div>
                    <div class="route">
                        <?php echo htmlspecialchars($row['source']); ?> → <?php echo htmlspecialchars($row['destination']); ?>
                    </div>
                    <div class="detail">
                        <i class="fa-regular fa-calendar"></i>
                        <span>Date: <?php echo date('d M Y', strtotime($row['date'])); ?></span>
                    </div>
                    <div class="detail">
                        <i class="fa-solid fa-chair"></i>
                        <span>Seats: <?php echo $row['seats_booked']; ?></span>
                    </div>
                    <div class="price">
                        ₹<?php echo number_format($row['price'] * $row['seats_booked']); ?>
                    </div>
                    <?php if ($row['status'] == 'Booked'): ?>
                        <button class="cancel-btn" onclick="cancelBooking(<?php echo $row['booking_id']; ?>)">
                            <i class="fa-solid fa-circle-xmark"></i> Cancel Booking
                        </button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-bookings">
                <i class="fa-solid fa-ticket-alt"></i>
                <h2>No Bookings Yet</h2>
                <p>You haven't booked any flights yet.</p>
                <div class="back-link" style="margin-top: 20px;">
                    <a href="dashboard.php">Browse Flights</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="back-link">
            <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<script>
function cancelBooking(bookingId) {
    if (confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
        window.location.href = 'cancel.php?id=' + bookingId;
    }
}
</script>

</body>
</html>