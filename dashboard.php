<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: test3.html"); // Redirect to login page if not logged in
    exit;
}

// Display the dashboard or protected content
echo "Welcome, " . $_SESSION['username'] . "!";
?>
