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
session_unset();
session_destroy();

header("Location: login.html");
exit();
?>