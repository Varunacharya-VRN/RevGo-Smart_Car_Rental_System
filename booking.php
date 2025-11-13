<?php 
    require_once('connection.php');
    session_start();
 
    if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

    $carid = $_GET['id'];
    
    $sql = "SELECT * FROM cars WHERE CAR_ID='$carid'";
    $cname = mysqli_query($con, $sql);
    $car = mysqli_fetch_assoc($cname);
    
    $value = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE EMAIL='$value'";
    $name = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($name);
    $uemail = $user['EMAIL'];
    $carprice = $car['PRICE'];
    
    $error_message = '';
    $success_message = '';

    if(isset($_POST['book'])){
        $bplace = mysqli_real_escape_string($con, $_POST['place']);
        $bdate = date('Y-m-d', strtotime($_POST['date']));
        $dur = mysqli_real_escape_string($con, $_POST['dur']);
        $phno = mysqli_real_escape_string($con, $_POST['ph']);
        $des = mysqli_real_escape_string($con, $_POST['des']);
        $rdate = date('Y-m-d', strtotime($_POST['rdate']));
         
        if(empty($bplace) || empty($bdate) || empty($dur) || empty($phno) || empty($des) || empty($rdate)){
            $error_message = "Please fill in all the fields";
        } else {
            if($bdate < $rdate) {
                $price = ($dur * $carprice);
                $sql = "INSERT INTO booking (CAR_ID, EMAIL, BOOK_PLACE, BOOK_DATE, DURATION, PHONE_NUMBER, DESTINATION, PRICE, RETURN_DATE) 
                       VALUES ($carid, '$uemail', '$bplace', '$bdate', $dur, $phno, '$des', $price, '$rdate')";
                $result = mysqli_query($con, $sql);
                
                if($result){
                    $_SESSION['email'] = $uemail;
                    header("Location: payment.php");
                    exit();
                } else {
                    $error_message = "There was an error with your booking. Please try again.";
                }
            } else {
                $error_message = "Please enter a valid return date that is after the booking date.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Car | RevGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <script type="text/javascript">
        function preventBack() {
            window.history.forward(); 
        }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
    </script>
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
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
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
            background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.7)), url("images/book.jpg");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-dark);
        }

        .page-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .booking-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 40px;
            align-items: stretch;
        }

        .car-details {
            flex: 1;
            min-width: 300px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            padding: 0;
            animation: fadeInLeft 0.8s ease;
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .car-info {
    padding: 20px;
        }

        .car-name {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .car-name i {
            color: var(--secondary);
            margin-right: 10px;
        }

        .car-spec {
            margin: 15px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .spec-item {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            background-color: var(--gray-100);
            border-radius: 50px;
            font-size: 14px;
        }

        .spec-item i {
            color: var(--secondary);
            margin-right: 8px;
        }

        .car-price {
            font-size: 22px;
            font-weight: 600;
            color: var(--secondary);
            margin-top: 15px;
            display: flex;
            align-items: center;
        }

        .car-price span {
            font-size: 16px;
            color: var(--text-light);
            margin-left: 5px;
        }

        .booking-form {
            flex: 2;
            min-width: 350px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            animation: fadeInRight 0.8s ease;
        }

        .form-header {
            padding: 20px;
            background-color: var(--secondary);
            text-align: center;
        }

        .form-header h2 {
            color: var(--white);
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .form-body {
            padding: 30px;
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius-sm);
            font-size: 14px;
            text-align: center;
        }

        .error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            min-width: 240px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
    font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius-sm);
            background-color: var(--white);
            color: var(--text-dark);
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }

        .form-control::placeholder {
            color: var(--text-light);
        }

        .price-calculator {
            background-color: var(--gray-100);
            padding: 15px;
            border-radius: var(--border-radius-sm);
            margin: 20px 0;
        }

        .price-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .price-breakdown {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: var(--text-light);
        }

        .price-total {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid var(--gray-300);
            font-weight: 600;
            color: var(--secondary);
        }

        .btn {
            display: inline-block;
            background-color: var(--secondary);
            color: var(--white);
            border: none;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: 500;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: var(--secondary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn i {
            margin-right: 8px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--secondary);
        }

        .back-link i {
            margin-right: 8px;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .booking-container {
                flex-direction: column;
            }
            
            .car-details, .booking-form {
                width: 100%;
            }
            
            .car-image {
                height: 180px;
            }
            
            .form-header h2 {
                font-size: 20px;
            }
            
            .form-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    
    <div class="page-container">
        <a href="cardetails.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Cars
        </a>
        
        <div class="booking-container">
            <div class="car-details">
                <?php if(isset($car['CAR_IMG']) && !empty($car['CAR_IMG'])): ?>
                    <img src="<?php echo $car['CAR_IMG']; ?>" alt="<?php echo $car['CAR_NAME']; ?>" class="car-image">
                <?php else: ?>
                    <img src="images/car-placeholder.jpg" alt="Car" class="car-image">
                <?php endif; ?>
                
                <div class="car-info">
                    <h2 class="car-name">
                        <i class="fas fa-car"></i>
                        <?php echo $car['CAR_NAME']; ?>
                    </h2>
                    
                    <div class="car-spec">
                        <?php if(isset($car['FUEL_TYPE'])): ?>
                        <div class="spec-item">
                            <i class="fas fa-gas-pump"></i> <?php echo $car['FUEL_TYPE']; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="spec-item">
                            <i class="fas fa-cog"></i> <?php echo isset($car['TRANSMISSION']) ? $car['TRANSMISSION'] : 'Automatic'; ?>
                </div>
                        
                        <div class="spec-item">
                            <i class="fas fa-users"></i> <?php echo isset($car['CAPACITY']) ? $car['CAPACITY'] . ' Seats' : '5 Seats'; ?>
                        </div>
                    </div>
                    
                    <div class="car-price">
                        ₹<?php echo number_format($car['PRICE']); ?> <span>per day</span>
                    </div>
                </div>
            </div>
            
            <div class="booking-form">
                <div class="form-header">
                    <h2><i class="fas fa-calendar-check"></i> Book Your Ride</h2>
       </div>
                
                <div class="form-body">
                    <?php if(!empty($error_message)): ?>
                        <div class="message error">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($success_message)): ?>
                        <div class="message success">
                            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="place" class="form-label">Pickup Location</label>
                                <input type="text" id="place" name="place" class="form-control" placeholder="Enter pickup location" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="des" class="form-label">Destination</label>
                                <input type="text" id="des" name="des" class="form-control" placeholder="Enter your destination" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="date" class="form-label">Pickup Date</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="rdate" class="form-label">Return Date</label>
                                <input type="date" id="rdate" name="rdate" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dur" class="form-label">Duration (days)</label>
                                <input type="number" id="dur" name="dur" min="1" max="30" class="form-control" placeholder="Number of days" required onchange="calculatePrice()">
                            </div>
                            
                            <div class="form-group">
                                <label for="ph" class="form-label">Contact Number</label>
                                <input type="tel" id="ph" name="ph" maxlength="10" class="form-control" placeholder="Your phone number" required>
                            </div>
                        </div>
                        
                        <div class="price-calculator">
                            <h3 class="price-title">Price Summary</h3>
                            <div class="price-breakdown">
                                <span>Daily Rate:</span>
                                <span>₹<?php echo number_format($car['PRICE']); ?></span>
                            </div>
                            <div class="price-breakdown">
                                <span>Number of Days:</span>
                                <span id="days-count">0</span>
                            </div>
                            <div class="price-total">
                                <span>Total Amount:</span>
                                <span id="total-price">₹0</span>
                            </div>
                        </div>
                        
                        <button type="submit" name="book" class="btn">
                            <i class="fas fa-check-circle"></i> Confirm Booking
                        </button>
        </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Set default dates
        window.onload = function() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            
            const bookingDate = document.getElementById('date');
            const returnDate = document.getElementById('rdate');
            
            // Format dates as YYYY-MM-DD for the input fields
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };
            
            // Set min dates and default values
            bookingDate.min = formatDate(today);
            bookingDate.value = formatDate(today);
            
            returnDate.min = formatDate(tomorrow);
            returnDate.value = formatDate(tomorrow);
            
            // Initialize price calculation
            document.getElementById('dur').value = 1;
            calculatePrice();
            
            // Add event listeners for date changes
            bookingDate.addEventListener('change', function() {
                const newBookingDate = new Date(this.value);
                const newMin = new Date(newBookingDate);
                newMin.setDate(newBookingDate.getDate() + 1);
                
                returnDate.min = formatDate(newMin);
                
                // If current return date is before the new min, update it
                if (new Date(returnDate.value) < newMin) {
                    returnDate.value = formatDate(newMin);
                }
                
                // Update duration based on selected dates
                updateDuration();
            });
            
            returnDate.addEventListener('change', function() {
                updateDuration();
            });
        };
        
        // Calculate and update the price based on duration
        function calculatePrice() {
            const duration = parseInt(document.getElementById('dur').value) || 0;
            const dailyRate = <?php echo $carprice; ?>;
            const totalPrice = duration * dailyRate;
            
            document.getElementById('days-count').textContent = duration;
            document.getElementById('total-price').textContent = '₹' + totalPrice.toLocaleString();
            
            // Update return date based on duration if it's a duration change
            const bookingDate = new Date(document.getElementById('date').value);
            const returnDate = new Date(bookingDate);
            returnDate.setDate(bookingDate.getDate() + duration);
            
            // Format the date as YYYY-MM-DD
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };
            
            document.getElementById('rdate').value = formatDate(returnDate);
        }
        
        // Update duration based on selected dates
        function updateDuration() {
            const bookingDate = new Date(document.getElementById('date').value);
            const returnDate = new Date(document.getElementById('rdate').value);
            
            // Calculate the difference in days
            const diffTime = returnDate.getTime() - bookingDate.getTime();
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            // Update duration field
            document.getElementById('dur').value = diffDays;
            
            // Recalculate price
            calculatePrice();
        }
        
        // Phone number validation - only allow numbers
        document.getElementById('ph').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>