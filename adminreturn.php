<?php

require_once('connection.php');

// Get parameters from URL
$carid = $_GET['id'];
$bookid = $_GET['bookid'];

// Check if parameters are valid
if (!isset($carid) || !isset($bookid)) {
    echo '<script>alert("Missing parameters!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

// Get booking details
$sql2 = "SELECT * FROM booking WHERE BOOK_ID=$bookid";
$result2 = mysqli_query($con, $sql2);

if (!$result2 || mysqli_num_rows($result2) == 0) {
    echo '<script>alert("Booking not found!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

$res2 = mysqli_fetch_assoc($result2);

// Get car details
$sql = "SELECT * FROM cars WHERE CAR_ID=$carid";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo '<script>alert("Car not found!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

$res = mysqli_fetch_assoc($result);

// Check if booking is already returned
if (strtoupper($res2['BOOK_STATUS']) == 'RETURNED') {
    echo '<script>alert("This booking is already marked as returned!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

// Check if car is already available
if ($res['AVAILABLE'] == 'Y') {
    echo '<script>alert("This car is already marked as available!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

// Update car status to available
$sql4 = "UPDATE cars SET AVAILABLE='Y' WHERE CAR_ID=$carid";
$query2 = mysqli_query($con, $sql4);

if (!$query2) {
    echo '<script>alert("Error updating car availability: ' . mysqli_error($con) . '");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

// Update booking status to returned
$sql5 = "UPDATE booking SET BOOK_STATUS='RETURNED' WHERE BOOK_ID=$bookid";
$query = mysqli_query($con, $sql5);

if (!$query) {
    echo '<script>alert("Error updating booking status: ' . mysqli_error($con) . '");</script>';
    
    // Rollback car availability change
    $rollback = "UPDATE cars SET AVAILABLE='N' WHERE CAR_ID=$carid";
    mysqli_query($con, $rollback);
    
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

echo '<script>alert("Car returned successfully!");</script>';
echo '<script>window.location.href = "adminbook.php";</script>';
?>