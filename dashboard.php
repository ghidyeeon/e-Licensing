<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: test3.html"); 
    exit;
}


echo "Welcome, " . $_SESSION['username'] . "!";
?>
