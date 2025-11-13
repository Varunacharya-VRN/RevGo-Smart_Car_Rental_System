<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    // User is not logged in, redirect to login page
    header("Location: index.php");
    exit();
}
?> 