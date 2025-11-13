<?php
require_once('connection.php');
session_start();

// Check if any session cleanup is needed (e.g., after logout)
if (isset($_SESSION['logged_out']) && $_SESSION['logged_out'] === true) {
    // This is a failsafe in case the logout script didn't fully clear the session
    $_SESSION = array();
    unset($_SESSION['logged_out']);
}

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    
    if(empty($email) || empty($pass)) {
        echo '<script>alert("please fill the blanks")</script>';
    } else {
        $query = "select * from users where EMAIL='$email'";
        $res = mysqli_query($con, $query);
        if($row = mysqli_fetch_assoc($res)) {
            $db_password = $row['PASSWORD'];
            if(md5($pass) == $db_password) {
                $_SESSION['email'] = $email;
                header("location: cardetails.php");
                exit(); // Add exit after redirect to prevent further execution
            } else {
                echo '<script>alert("Enter a proper password")</script>';
            }
        } else {
            echo '<script>alert("enter a proper email")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RevGo | Car Rental</title>
    <script type="text/javascript">
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="text/javascript">
        function preventBack() {
            window.history.forward(); 
        }
          
        setTimeout("preventBack()", 0);
          
        window.onunload = function () { null };
    </script>
    <style>
        .content {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 50px auto 0;
            padding: 0 20px;
        }
        
        .text-section {
            flex: 1;
            padding-right: 40px;
        }
        
        .text-section h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: #fff;
        }
        
        .text-section h1 span {
            color: var(--secondary);
        }
        
        .par {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #f1f5f9;
        }
        
        .cn {
            background: linear-gradient(90deg, var(--secondary), var(--secondary-dark));
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .cn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
        }
        
        .cn a {
            text-decoration: none;
            color: inherit;
        }
        
        .form {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 350px;
        }
        
        .form h2 {
            text-align: center;
            color: var(--text-dark);
            font-size: 28px;
            margin-bottom: 30px;
            position: relative;
        }
        
        .form h2::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background: var(--secondary);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .form input {
            width: 100%;
            padding: 12px 15px;
            margin: 15px 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }
        
        .form input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            outline: none;
        }
        
        .btnn {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: linear-gradient(90deg, var(--secondary), var(--secondary-dark));
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btnn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(249, 115, 22, 0.3);
        }
        
        .link {
            text-align: center;
            margin-top: 25px;
            color: var(--text-light);
        }
        
        .link a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .link a:hover {
            color: var(--secondary-dark);
        }
        
        /* Password toggle styling */
        .password-container {
            position: relative;
            width: 100%;
        }
        
        .password-container input {
            width: 100%;
            padding-right: 40px;
        }
        
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--text-light);
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none;
            transition: color 0.3s ease;
        }
        
        .toggle-password:hover {
            color: var(--secondary);
        }
        
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
        
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
                padding: 20px;
            }
            
            .text-section {
                padding-right: 0;
                margin-bottom: 40px;
                text-align: center;
            }
            
            .form {
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }
            
            .text-section h1 {
                font-size: 2.5rem;
            }
        }

        /* Fixing the admin button style to match other buttons */
        .adminbtn {
            background-color: transparent;
            border: 2px solid var(--secondary);
            color: var(--text-dark);
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .adminbtn:hover {
            background-color: var(--secondary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(249, 115, 22, 0.3);
        }

        .adminbtn a {
            text-decoration: none;
            color: inherit;
        }

        /* Ensure navbar positioning is correct */
        .navbar {
            width: 100%;
        }

        .navbar .container {
            padding: 0 20px;
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="content">
    <div class="text-section">
        <h1>Rent Your <br><span>Dream Car</span></h1>
        <p class="par">Live the life of Luxury.<br>
            Just rent a car of your wish from our vast collection.<br>Enjoy every moment with your family<br>
            Join us to make this family vast.</p>
        <button class="cn"><a href="register.php">JOIN US</a></button>
    </div>
    
    <div class="form">
        <h2>Login Here</h2>
        <form method="POST"> 
            <input type="email" name="email" placeholder="Enter Email Here" required>
            <div class="password-container">
                <input type="password" name="pass" id="password" placeholder="Enter Password Here" required>
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </button>
            </div>
            <button class="btnn" type="submit" name="login">Login</button>
        </form>
        <p class="link">Don't have an account? <a href="register.php">Sign up here</a></p>
    </div>
</div>
    
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
