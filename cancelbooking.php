<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking | RevGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
<style>
    :root {
        --primary: #2563eb;
        --primary-light: #3b82f6;
        --primary-dark: #1d4ed8;
        --secondary: #f97316;
        --secondary-dark: #ea580c;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --bg-light: #f8fafc;
        --bg-dark: #0f172a;
        --white: #ffffff;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-800: #1e293b;
        --danger: #ef4444;
        --transition: all 0.3s ease;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --border-radius: 12px;
        --border-radius-sm: 8px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.7)), url("images/carbg2.jpg");
        background-position: center;
        background-size: cover;
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .cancel-container {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        max-width: 600px;
        width: 90%;
        padding: 40px;
        text-align: center;
        animation: fadeIn 0.8s ease;
    }

    .warning-icon {
        font-size: 64px;
        color: var(--danger);
        margin-bottom: 20px;
    }

    h1 {
        font-size: 24px;
        color: var(--text-dark);
        margin-bottom: 30px;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: var(--border-radius-sm);
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-danger {
        background-color: var(--danger);
        color: var(--white);
    }

    .btn-danger:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary {
        background-color: var(--gray-200);
        color: var(--text-dark);
    }

    .btn-secondary:hover {
        background-color: var(--gray-300);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .cancel-container {
            padding: 30px 20px;
        }

        h1 {
            font-size: 20px;
        }

        .btn-container {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<?php
    require_once('connection.php');
    session_start();

    // Check if user is logged in
    if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

    $email = $_SESSION['email'];
    
    // Get the latest booking for this user
    $sql = "SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_ID DESC LIMIT 1";
    $result = mysqli_query($con, $sql);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<script>alert("No booking found!");</script>';
        echo '<script>window.location.href = "cardetails.php";</script>';
        exit();
    }
    
    $booking = mysqli_fetch_assoc($result);
    $bid = $booking['BOOK_ID'];
    
    if(isset($_POST['cancelnow'])) {
        $del = mysqli_query($con, "DELETE FROM booking WHERE BOOK_ID = '$bid'");
        
        if ($del) {
            echo "<script>alert('Booking cancelled successfully!');</script>";
            echo "<script>window.location.href='cardetails.php';</script>";
        } else {
            echo "<script>alert('Error cancelling booking: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<?php include('navbar.php'); ?>

<div class="cancel-container">
    <i class="fas fa-exclamation-triangle warning-icon"></i>
    <h1>Are you sure you want to cancel your booking?</h1>
    <p>This action cannot be undone. Booking ID: <?php echo $bid; ?></p>
    
    <div class="btn-container">
        <form method="POST">
            <button type="submit" name="cancelnow" class="btn btn-danger">
                <i class="fas fa-times"></i> Yes, Cancel Booking
            </button>
        </form>
        <a href="payment.php" class="btn btn-secondary">
            <i class="fas fa-credit-card"></i> No, Go to Payment
        </a>
    </div>
</div>

</body>
</html>
