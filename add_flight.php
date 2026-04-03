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

// Admin check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$name        = $_POST['name'];
$source      = $_POST['source'];
$destination = $_POST['destination'];
$date        = $_POST['date'];
$seats       = $_POST['seats'];
$price       = $_POST['price'];

$stmt = $conn->prepare("INSERT INTO flights(flight_name, source, destination, date, seats, price) VALUES(?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssis", $name, $source, $destination, $date, $seats, $price);
$stmt->execute();

header("Location: admin.php");
?>