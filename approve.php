<?php

require_once('connection.php');

// Get booking ID from URL
$bookid = $_GET['bookid'];
$carid = $_GET['id'];

// Get booking details
$sql = "SELECT * FROM booking WHERE BOOK_ID=$bookid";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo '<script>alert("Booking not found!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

$res = mysqli_fetch_assoc($result);
$car_id = $res['CAR_ID'];

// Get car details
$sql2 = "SELECT * FROM cars WHERE CAR_ID=$car_id";
$carres = mysqli_query($con, $sql2);

if (!$carres || mysqli_num_rows($carres) == 0) {
    echo '<script>alert("Car not found!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
    exit();
}

$carresult = mysqli_fetch_assoc($carres);
$email = $res['EMAIL'];
$carname = $carresult['CAR_NAME'];

// Check if car is available
if ($carresult['AVAILABLE'] == 'Y') {
    // Check booking status (case-insensitive comparison for reliability)
    if (strtoupper($res['BOOK_STATUS']) == 'APPROVED' || strtoupper($res['BOOK_STATUS']) == 'RETURNED') {
        echo '<script>alert("Booking already approved or returned!");</script>';
        echo '<script>window.location.href = "adminbook.php";</script>';
    } else {
        // Update booking status to APPROVED
        $query = "UPDATE booking SET BOOK_STATUS='APPROVED' WHERE BOOK_ID=$bookid";
        $queryy = mysqli_query($con, $query);
        
        if (!$queryy) {
            echo '<script>alert("Error updating booking status: ' . mysqli_error($con) . '");</script>';
            echo '<script>window.location.href = "adminbook.php";</script>';
            exit();
        }
        
        // Update car availability to N (not available)
        $sql2 = "UPDATE cars SET AVAILABLE='N' WHERE CAR_ID=$car_id";
        $query2 = mysqli_query($con, $sql2);
        
        if (!$query2) {
            echo '<script>alert("Error updating car availability: ' . mysqli_error($con) . '");</script>';
            echo '<script>window.location.href = "adminbook.php";</script>';
            exit();
        }
        
        echo '<script>alert("Booking approved successfully!");</script>';
        
        // Email notification code (commented out)
        // $to_email = $email;
        // $subject = "DONOT-REPLY";
        // $body = "YOUR BOOKING FOR THE CAR $carname IS BEEN APPROVED WITH BOOKING ID : $bookid";
        // $headers = "From: sender email";
        
        // if (mail($to_email, $subject, $body, $headers)) {
        //     echo "Email successfully sent to $to_email...";
        // } else {
        //     echo "Email sending failed!";
        // }
        
        echo '<script>window.location.href = "adminbook.php";</script>';
    }
} else {
    echo '<script>alert("Car is not available!");</script>';
    echo '<script>window.location.href = "adminbook.php";</script>';
}


?>