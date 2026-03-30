<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Get all flights
$result = $conn->query("SELECT * FROM flights ORDER BY date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skywings - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Login ke baad wali background image - YAHI CHANGE HOGA */
        body {
            background: url('images/dashboard-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        
        .user-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            padding: 15px 50px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .user-nav h2 {
            color: #60f106;
        }
        
        .user-nav h2 i {
            margin-right: 10px;
        }
        
        .user-nav .nav-links a {
            color: white;
            margin-left: 25px;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .user-nav .nav-links a:hover {
            color: #ff4b2b;
        }
        
        .user-profile {
            position: relative;
            cursor: pointer;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #ff4b2b;
        }
        
        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background: white;
            color: black;
            padding: 15px;
            width: 220px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .profile-dropdown p {
            margin: 5px 0;
        }
        
        .profile-dropdown hr {
            margin: 10px 0;
        }
        
        .profile-dropdown a {
            display: block;
            color: #333;
            text-decoration: none;
            padding: 8px 0;
            transition: color 0.3s;
        }
        
        .profile-dropdown a:hover {
            color: #ff4b2b;
        }
        
        .hero-section {
            text-align: center;
            padding: 60px 20px;
            background: rgba(0, 0, 0, 0.5);
            margin: 30px;
            border-radius: 20px;
        }
        
        .hero-section h1 {
            font-size: 48px;
            color: #ffcc00;
        }
        
        .hero-section p {
            font-size: 20px;
            margin: 15px 0;
            color: white;
        }
        
        .search-box {
            background: rgba(255,255,255,0.2);
            padding: 25px;
            border-radius: 15px;
            backdrop-filter: blur(8px);
            display: inline-flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .search-box input {
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            outline: none;
            width: 180px;
        }
        
        .search-box button {
            padding: 12px 25px;
            background: linear-gradient(135deg, #ff4b2b, #ffcc00);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .features-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 50px 20px;
            gap: 30px;
        }
        
        .feature-card {
            background: white;
            color: black;
            padding: 30px;
            border-radius: 15px;
            width: 250px;
            text-align: center;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-card i {
            font-size: 40px;
            color: #ff4b2b;
            margin-bottom: 15px;
        }
        
        .flights-section {
            padding: 50px 20px;
            background: rgba(255, 255, 255, 0.9);
            margin-top: 30px;
        }
        
        .flights-section h2 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 32px;
        }
        
        .flights-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .flight-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            width: 280px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .flight-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .flight-card h3 {
            color: #1e3c72;
            margin-bottom: 10px;
        }
        
        .flight-route {
            font-size: 18px;
            font-weight: bold;
            color: #ff4b2b;
            margin: 10px 0;
        }
        
        .flight-details {
            color: #666;
            margin: 8px 0;
        }
        
        .flight-price {
            font-size: 24px;
            font-weight: bold;
            color: #2ecc71;
            margin: 10px 0;
        }
        
        .booking-form {
            margin-top: 15px;
        }
        
        .booking-form input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .booking-form button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #ff4b2b, #ffcc00);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .booking-form button:hover {
            opacity: 0.9;
        }
        
        .no-flights {
            text-align: center;
            color: #666;
            padding: 50px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="user-nav">
    <h2><i class="fa-solid fa-plane"></i> Skywings</h2>
    <div class="nav-links">
        <a href="dashboard.php">Home</a>
        <a href="my_bookings.php">My Bookings</a>
    </div>
    <div class="user-profile" onclick="toggleMenu()">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile">
        <div id="profileMenu" class="profile-dropdown">
            <p><strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
            <p><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
            <hr>
            <a href="my_bookings.php"><i class="fa-solid fa-ticket"></i> My Bookings</a>
            <a href="logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</div>

<!-- Hero Section -->
<div class="hero-section">
    <h1>Welcome Back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <p>Book flights at best prices for a comfortable journey</p>
    
    <form class="search-box" action="search.php" method="GET" onsubmit="return validateSearch()">
        <input type="text" name="source" placeholder="From City" required>
        <input type="text" name="destination" placeholder="To City" required>
        <input type="date" name="date" required>
        <button type="submit"><i class="fa-solid fa-search"></i> Search Flights</button>
    </form>
</div>

<!-- Features Section -->
<div class="features-section">
    <div class="feature-card">
        <i class="fa-solid fa-plane"></i>
        <h3>Fast Booking</h3>
        <p>Book flights quickly in just a few clicks</p>
    </div>
    <div class="feature-card">
        <i class="fa-solid fa-indian-rupee-sign"></i>
        <h3>Best Price</h3>
        <p>Lowest price guarantee on all flights</p>
    </div>
    <div class="feature-card">
        <i class="fa-solid fa-shield-halved"></i>
        <h3>Safe Travel</h3>
        <p>Secure and comfortable journey</p>
    </div>
    <div class="feature-card">
        <i class="fa-solid fa-headset"></i>
        <h3>24/7 Support</h3>
        <p>Round the clock customer service</p>
    </div>
</div>

<!-- Flights Section -->
<div class="flights-section">
    <h2><i class="fa-solid fa-plane-departure"></i> Available Flights</h2>
    <div class="flights-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="flight-card">
                    <h3><i class="fa-solid fa-plane"></i> <?php echo htmlspecialchars($row['flight_name']); ?></h3>
                    <div class="flight-route">
                        <?php echo htmlspecialchars($row['source']); ?> → <?php echo htmlspecialchars($row['destination']); ?>
                    </div>
                    <div class="flight-details">
                        <i class="fa-regular fa-calendar"></i> Date: <?php echo date('d M Y', strtotime($row['date'])); ?>
                    </div>
                    <div class="flight-details">
                        <i class="fa-solid fa-chair"></i> Seats Available: <?php echo $row['seats']; ?>
                    </div>
                    <div class="flight-price">
                        ₹<?php echo number_format($row['price']); ?>
                    </div>
                    <?php if ($row['seats'] > 0): ?>
                        <form class="booking-form" action="book.php" method="post" onsubmit="return bookingPopup()">
                            <input type="hidden" name="flight_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="seats" placeholder="Number of seats" min="1" max="<?php echo $row['seats']; ?>" required>
                            <button type="submit"><i class="fa-solid fa-bookmark"></i> Book Now</button>
                        </form>
                    <?php else: ?>
                        <button style="background: #ccc; cursor: not-allowed;" disabled>Sold Out</button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-flights">
                <i class="fa-solid fa-plane-slash" style="font-size: 48px; color: #999;"></i>
                <p>No flights available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Profile menu toggle
function toggleMenu() {
    let menu = document.getElementById("profileMenu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

// Close dropdown on outside click
document.addEventListener("click", function(event) {
    let menu = document.getElementById("profileMenu");
    if (!menu) return;
    if (!event.target.closest(".user-profile")) {
        menu.style.display = "none";
    }
});

// Search validation
function validateSearch() {
    let source = document.querySelector("input[name='source']");
    let destination = document.querySelector("input[name='destination']");
    let date = document.querySelector("input[name='date']");
    
    if (source.value === "" || destination.value === "" || date.value === "") {
        alert("Please fill all search fields");
        return false;
    }
    return true;
}

// Booking popup
function bookingPopup() {
    alert("Processing your booking...");
    return true;
}
</script>

</body>
</html>