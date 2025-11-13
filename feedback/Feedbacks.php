<?php
// Start session at the very beginning before any output
session_start();

// Check if user is logged in
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    // User is not logged in, redirect to login page
    header("Location: ../index.php");
    exit();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../connection.php');

// Initialize variables
$alertMessage = '';
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Check if connection is established
if (!isset($con) || $con === false) {
    $alertMessage = '<div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> Database connection error. Please try again later.
    </div>';
}

if(isset($_POST['submit'])){
    $name = isset($_POST['name']) ? mysqli_real_escape_string($con, $_POST['name']) : '';
    $email_input = isset($_POST['email']) ? mysqli_real_escape_string($con, $_POST['email']) : '';
    $comment = isset($_POST['comment']) ? mysqli_real_escape_string($con, $_POST['comment']) : '';
    
    // Use the input email if no session email is available
    $emailToUse = !empty($userEmail) ? $userEmail : $email_input;
    
    $sql = "INSERT INTO feedback (EMAIL, COMMENT) VALUES ('$emailToUse', '$comment')";
    $result = mysqli_query($con, $sql);
    
    if($result) {
        $alertMessage = '<div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle me-2"></i> Feedback sent successfully! Thank you for your input.
        </div>';
        
        // Redirect after 2 seconds
        echo '<script>
            setTimeout(function() {
                window.location.href = "../cardetails.php";
            }, 2000);
        </script>';
    } else {
        $alertMessage = '<div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> Error: ' . mysqli_error($con) . '
        </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RevGo | Feedback</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #0f172a;
            --secondary: #f97316;
            --secondary-dark: #ea580c;
            --accent: #3b82f6;
            --text-light: #f8fafc;
            --text-dark: #334155;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("../images/jamie-street.jpg");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #fff;
        }
        
        .feedback-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px 20px 40px;
        }
        
        .feedback-card {
            display: flex;
            flex-direction: column;
            max-width: 800px;
            width: 100%;
            background: rgba(18, 25, 44, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            padding: 40px;
        }
        
        .feedback-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .feedback-title {
            font-size: 3rem;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
            background: linear-gradient(90deg, #f97316, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .feedback-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--secondary);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .submit-btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(90deg, var(--secondary), var(--accent));
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            border: none;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 5px 15px rgba(249, 115, 22, 0.3);
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.4);
        }
        
        .submit-btn i {
            margin-right: 8px;
        }
        
        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            animation: fadeInDown 0.5s ease;
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-success {
            background: rgba(46, 213, 115, 0.2);
            border: 1px solid rgba(46, 213, 115, 0.3);
            color: #2ed573;
        }
        
        .alert-danger {
            background: rgba(255, 71, 87, 0.2);
            border: 1px solid rgba(255, 71, 87, 0.3);
            color: #ff4757;
        }
        
        @media (max-width: 768px) {
            .feedback-card {
                padding: 30px;
            }
            
            .feedback-title {
                font-size: 2rem;
            }
            
            .submit-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Include the RevGo Navbar -->
    <div class="navbar">
        <div class="container">
            <a href="../cardetails.php" class="logo">RevGo</a>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="../cardetails.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="../aboutus2.html"><i class="fas fa-info-circle"></i> About</a></li>
                    <li><a href="../contactus2.html"><i class="fas fa-envelope"></i> Contact</a></li>
                    <li><a href="Feedbacks.php" class="active"><i class="fas fa-comments"></i> Feedback</a></li>
                    <li><a href="../bookinstatus.php" class="book-status"><i class="fas fa-calendar-check"></i> Booking Status</a></li>
                    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="feedback-container">
        <div class="feedback-card">
            <div class="feedback-header">
                <h1 class="feedback-title">Feedback</h1>
                <p>We value your opinion. Please share your thoughts with us to help improve our services.</p>
            </div>

            <?php echo $alertMessage; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="comment" class="form-label">Your Message</label>
                    <textarea class="form-control" id="comment" name="comment" rows="6" placeholder="Share your experience with us..." required></textarea>
                </div>
                
                <button type="submit" class="submit-btn" name="submit">
                    <i class="fas fa-paper-plane"></i> Send Feedback
                </button>
            </form>
        </div>
    </div>

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
    </script>
</body>
</html>
