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

// Get all flights
$result = $conn->query("SELECT * FROM flights ORDER BY date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skywings - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="dashboard-body">

<!-- Navbar -->
<div class="user-nav">
    <h2><i class="fa-solid fa-plane"></i> Skywings</h2>

    <div>
        <a href="dashboard.php">Home</a>
        <a href="my_bookings.php">My Bookings</a>
    </div>

    <div class="user-profile" onclick="toggleMenu()">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
        <div id="profileMenu" class="profile-dropdown">
            <p><strong><?php echo $_SESSION['user_name'] ?? 'User'; ?></strong></p>
            <p><?php echo $_SESSION['user_email'] ?? ''; ?></p>
            <hr>
            <a href="my_bookings.php">My Bookings</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<!-- Hero -->
<div class="hero-section">
    <h1>Welcome <?php echo $_SESSION['user_name'] ?? 'User'; ?>!</h1>
    <p>Book flights easily</p>
</div>

<!-- Flights -->
<div class="flights-section">
    <h2>Available Flights</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="flight-card">
                <h3><?php echo $row['flight_name']; ?></h3>
                <p><?php echo $row['source']; ?> → <?php echo $row['destination']; ?></p>
                <p>Date: <?php echo $row['date']; ?></p>
                <p>Seats: <?php echo $row['seats']; ?></p>
                <p class="flight-price">₹<?php echo $row['price']; ?></p>

                <form action="book.php" method="post">
                    <input type="hidden" name="flight_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="seats" placeholder="Seats" required>
                    <button type="submit">Book</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No flights available</p>
    <?php endif; ?>
</div>

<script>
function toggleMenu() {
    let menu = document.getElementById("profileMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
</script>

</body>
</html>