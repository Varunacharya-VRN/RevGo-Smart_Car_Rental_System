<?php
    require_once('connection.php');
    session_start();
    $email = $_SESSION['email'] ?? '';

    $sql="select * from booking where EMAIL='$email' order by BOOK_ID DESC LIMIT 1";
    $name = mysqli_query($con,$sql);
    $rows=mysqli_fetch_assoc($name);
    
    $sql2="select * from users where EMAIL='$email'";
    $name2 = mysqli_query($con,$sql2);
    $rows2=mysqli_fetch_assoc($name2);
    
    if($rows==null){
        echo '<script>alert("THERE ARE NO BOOKING DETAILS")</script>';
        echo '<script> window.location.href = "cardetails.php";</script>';
    }
    else{
    $car_id=$rows['CAR_ID'];
    $sql3="select * from cars where CAR_ID='$car_id'";
    $name3 = mysqli_query($con,$sql3);
    $rows3=mysqli_fetch_assoc($name3);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Status | RevGo</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.7)), url("images/carbg2.jpg");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-dark);
        }

        .page-title {
            text-align: center;
            margin: 40px 0;
            color: var(--white);
            font-size: 32px;
            font-weight: 700;
            animation: fadeIn 0.8s ease;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .page-title::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary), var(--primary));
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .booking-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            animation: fadeIn 0.8s ease;
        }

        .booking-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--gray-200);
        }

        .booking-header .user-greeting {
            font-size: 24px;
            color: var(--text-dark);
            font-weight: 600;
            margin-left: 20px;
        }

        .booking-header .user-name {
            color: var(--secondary);
        }

        .booking-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .booking-info {
            background-color: var(--bg-light);
            padding: 25px;
            border-radius: var(--border-radius-sm);
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .booking-info:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .booking-info h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--text-light);
            border-bottom: 1px solid var(--gray-200);
            padding-bottom: 10px;
        }

        .booking-info p {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 5px 0;
            display: flex;
            align-items: center;
        }

        .booking-info p i {
            color: var(--secondary);
            margin-right: 10px;
            font-size: 20px;
            width: 30px;
            text-align: center;
        }

        .status {
            background-color: var(--primary-light);
            color: white !important;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 16px !important;
            display: inline-block !important;
            font-weight: 500 !important;
        }

        .status.confirmed {
            background-color: #10b981;
        }

        .status.pending {
            background-color: #f59e0b;
        }

        .status.cancelled {
            background-color: #ef4444;
        }

        .actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-btn.primary {
            background-color: var(--secondary);
            color: white;
        }
        
        .action-btn.primary:hover {
            background-color: var(--secondary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }
        
        .action-btn.secondary {
            background-color: var(--gray-200);
            color: var(--text-dark);
        }
        
        .action-btn.secondary:hover {
            background-color: var(--gray-100);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .no-bookings {
            text-align: center;
            padding: 50px 20px;
        }

        .no-bookings h2 {
            font-size: 24px;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .no-bookings p {
            color: var(--text-light);
            margin-bottom: 30px;
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
            .booking-container {
                padding: 20px;
                margin: 30px 15px;
            }
            
            .booking-details {
                grid-template-columns: 1fr;
            }
            
            .booking-header {
                flex-direction: column;
                text-align: center;
            }
            
            .booking-header .user-greeting {
                margin: 15px 0 0 0;
                font-size: 20px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <h1 class="page-title">Booking Status</h1>

    <?php if($rows==null): ?>
    <div class="booking-container no-bookings">
        <h2>No Booking Details Available</h2>
        <p>You haven't made any bookings yet. Explore our car selection and book your first ride!</p>
        <a href="cardetails.php" class="action-btn primary"><i class="fas fa-car"></i> Browse Cars</a>
    </div>
    <?php else: ?>
    <div class="booking-container">
        <div class="booking-header">
            <div class="user-greeting">Hello, <span class="user-name"><?php echo $rows2['FNAME']." ".$rows2['LNAME']; ?></span></div>
        </div>
        
        <div class="booking-details">
            <div class="booking-info">
                <h3>Car Details</h3>
                <p><i class="fas fa-car"></i> <?php echo $rows3['CAR_NAME']; ?></p>
                <p><i class="fas fa-tag"></i> Car ID: <?php echo $rows['CAR_ID']; ?></p>
            </div>
            
            <div class="booking-info">
                <h3>Booking Details</h3>
                <p><i class="fas fa-calendar-day"></i> Duration: <?php echo $rows['DURATION']; ?> days</p>
                <p><i class="fas fa-clock"></i> Status: 
                    <span class="status <?php 
                        echo strtolower($rows['BOOK_STATUS']) == 'confirmed' ? 'confirmed' : 
                            (strtolower($rows['BOOK_STATUS']) == 'cancelled' ? 'cancelled' : 'pending'); 
                    ?>">
                        <?php echo $rows['BOOK_STATUS']; ?>
                    </span>
                </p>
         </div>
     </div>

        <div class="actions">
            <a href="cardetails.php" class="action-btn primary"><i class="fas fa-home"></i> Return to Home</a>
            <?php if(strtolower($rows['BOOK_STATUS']) != 'cancelled'): ?>
            <a href="cancelbooking.php" class="action-btn secondary"><i class="fas fa-ban"></i> Cancel Booking</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Mobile menu toggle
        const menuToggle = document.querySelector('.menu-toggle');
        const menu = document.querySelector('.menu');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                menu.classList.toggle('active');
                this.classList.toggle('active');
            });
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!menu.contains(event.target) && !menuToggle.contains(event.target) && menu.classList.contains('active')) {
                menu.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    </script>
</body>
</html>