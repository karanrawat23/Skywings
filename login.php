<?php
session_start();
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $row = $result->fetch_assoc();

    if($row['password'] == $password){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];

        header("Location: dashboard.php");
    } else {
        echo "Wrong Password";
    }
} else {
    echo "User not found";
}
?>