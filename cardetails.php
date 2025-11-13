<?php 
    require_once('connection.php');
    session_start();

    $value = $_SESSION['email'] ?? '';
    $_SESSION['email'] = $value;
    
    $sql = "select * from users where EMAIL='$value'";
    $name = mysqli_query($con, $sql);
    $rows = mysqli_fetch_assoc($name);
    
    $sql2 = "select * from cars where AVAILABLE='Y'";
    $cars = mysqli_query($con, $sql2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details | RevGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --white: #ffffff;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --transition: all 0.3s ease;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --border-radius: 12px;
            --border-radius-sm: 8px;
        }

        body {
            background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.7)), url("images/carbg2.jpg");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .page-title {
            text-align: center;
            margin: 40px 0;
            color: var(--white);
            font-size: 36px;
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

        .car-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .car-card {
            position: relative;
            background-color: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275), 
                        box-shadow 0.5s ease;
            animation: fadeIn 0.8s ease;
            animation-fill-mode: both;
            isolation: isolate;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .car-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .car-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary-light), var(--secondary));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.5s ease;
            border-radius: var(--border-radius);
        }

        .car-card:hover::before {
            opacity: 0.05;
        }

        .car-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .car-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(0deg, rgba(0,0,0,0.3), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .car-card:hover .car-image::after {
            opacity: 1;
        }

        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        .car-card:hover .car-image img {
            transform: scale(1.15) rotate(-2deg);
        }

        .car-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--secondary);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 10;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .car-card:hover .car-tag {
            opacity: 1;
            transform: translateY(0);
        }

        .car-details {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
            background-color: var(--white);
            z-index: 1;
        }

        .car-name {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .car-name::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background-color: var(--secondary);
            bottom: -5px;
            left: 0;
            transition: width 0.3s ease;
        }

        .car-card:hover .car-name::after {
            width: 70px;
        }

        .car-info-wrapper {
            margin: 15px 0;
        }

        .car-info {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-light);
            transition: transform 0.3s ease;
            padding: 5px 0;
        }

        .car-card:hover .car-info {
            transform: translateX(5px);
        }

        .car-info i {
            color: var(--secondary);
            font-size: 18px;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--gray-100);
            border-radius: 50%;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .car-card:hover .car-info i {
            background-color: var(--secondary);
            color: var(--white);
            transform: scale(1.1);
        }

        .car-price {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin: 15px 0 20px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .car-price small {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-light);
        }

        .book-btn {
            display: inline-block;
            background: linear-gradient(90deg, var(--secondary), var(--secondary-dark));
            color: var(--white);
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: 0.3s ease;
            text-align: center;
            text-decoration: none;
            width: 100%;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 1;
            margin-top: auto;
        }

        .book-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transition: width 0.4s ease;
            z-index: -1;
        }

        .book-btn:hover::before {
            width: 100%;
        }

        .book-btn:hover {
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        /* Advanced animations */
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

        /* For animation delay in car cards */
        .car-card:nth-child(1) { animation-delay: 0.1s; }
        .car-card:nth-child(2) { animation-delay: 0.2s; }
        .car-card:nth-child(3) { animation-delay: 0.3s; }
        .car-card:nth-child(4) { animation-delay: 0.4s; }
        .car-card:nth-child(5) { animation-delay: 0.5s; }
        .car-card:nth-child(6) { animation-delay: 0.6s; }

        /* Responsive styles */
        @media (max-width: 992px) {
            .car-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .car-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                padding: 15px;
                gap: 20px;
            }
            
            .page-title {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .car-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 24px;
            }
            
            .car-image {
                height: 180px;
            }
            
            .car-details {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
<?php include('navbar.php'); ?>

<h1 class="page-title">Explore Our Premium Fleet</h1>

<div class="car-grid">
    <?php while($result = mysqli_fetch_array($cars)) { ?>
    <div class="car-card">
        <div class="car-image">
            <img src="images/<?php echo $result['CAR_IMG']; ?>" alt="<?php echo $result['CAR_NAME']; ?>">
            <div class="car-tag">Available Now</div>
        </div>
        <div class="car-details">
            <h2 class="car-name"><?php echo $result['CAR_NAME']; ?></h2>
            
            <div class="car-info-wrapper">
                <div class="car-info">
                    <i class="fas fa-gas-pump"></i>
                    <span><?php echo $result['FUEL_TYPE']; ?></span>
                </div>
                
                <div class="car-info">
                    <i class="fas fa-users"></i>
                    <span><?php echo $result['CAPACITY']; ?> Persons</span>
                </div>
                
                <div class="car-info">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Instant Booking</span>
                </div>
            </div>
            
            <div class="car-price">
                ₹<?php echo $result['PRICE']; ?>/-<small>per day</small>
            </div>
            
            <a href="booking.php?id=<?php echo $result['CAR_ID']; ?>" class="book-btn">Book Now</a>
        </div>
    </div>
    <?php } ?>
</div>

<script>
    // Add card hover effect
    document.querySelectorAll('.car-card').forEach(card => {
        card.addEventListener('mouseover', function() {
            this.style.zIndex = "5";
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = "1";
        });
    });
</script>
</body>
</html>