<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];

// 🔥 PASSWORD HASHING
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// 👉 CHECK EMAIL ALREADY EXISTS
$check = $conn->query("SELECT * FROM users WHERE email='$email'");

if($check->num_rows > 0){
    echo "<script>alert('Email already exists'); window.location='register.html';</script>";
} else {

    // ✅ INSERT QUERY (yaha $password use ho raha hai)
    $sql = "INSERT INTO users (name, email, password) 
            VALUES ('$name', '$email', '$password')";

    if($conn->query($sql)){
        echo "<script>alert('Registration Successful'); window.location='login.html';</script>";
    } else {
        echo "Error";
    }
}
?>