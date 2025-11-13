<?php
    require_once('connection.php');
    session_start();
    
    if(isset($_POST['adlog'])){
        $id=$_POST['adid'];
        $pass=$_POST['adpass'];
        
        if(empty($id)|| empty($pass)) {
            $error_msg = "Please fill all the fields";
        } else {
            $query="select * from admin where ADMIN_ID='$id'";
            $res=mysqli_query($con,$query);
            if($row=mysqli_fetch_assoc($res)){
                $db_password = $row['ADMIN_PASSWORD'];
                if($pass == $db_password) {
                    $_SESSION['admin'] = $id;
                    header("location: admindash.php");
                    exit();
                } else {
                    $error_msg = "Incorrect password";
                }
            } else {
                $error_msg = "Admin ID not found";
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
    <title>Admin Login | RevGo</title>
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
            --gray-800: #1e293b;
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
            background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.7)), url("images/michael-lock-Jcz3IO5ibHM-unsplash.jpg");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }

        .error-message {
            background-color: rgba(220, 38, 38, 0.15);
            color: #fecaca;
            padding: 12px 20px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 20px;
            border: 1px solid rgba(220, 38, 38, 0.3);
            text-align: center;
            font-size: 14px;
            max-width: 450px;
            width: 100%;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .vintage-decoration {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 600px;
            opacity: 0.7;
            z-index: -1;
            filter: drop-shadow(0 10px 8px rgba(0, 0, 0, 0.4));
        }
        
        .vintage-car {
            position: absolute;
            bottom: 20px;
            left: 20px;
            width: 250px;
            height: 120px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" fill="%23f97316"><path d="M171.3 96H224v96H111.3l30.4-75.9C146.5 104 158.2 96 171.3 96zM272 192V96h81.2c9.7 0 18.9 4.4 25 12l67.2 84H272zm256.2 1L428.2 68c-18.2-22.8-45.8-36-75-36H171.3c-39.3 0-74.6 23.9-89.1 60.3L40.6 196.4C16.8 205.8 0 228.9 0 256v112c0 17.7 14.3 32 32 32h33.3c7.6 45.4 47.1 80 94.7 80s87.1-34.6 94.7-80H385.3c7.6 45.4 47.1 80 94.7 80s87.1-34.6 94.7-80H608c17.7 0 32-14.3 32-32v-80c0-53-43-96-96-96h-16.2zM160 432c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48z"/></svg>');
            background-repeat: no-repeat;
            opacity: 0.3;
        }
        
        .vintage-car2 {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 250px;
            height: 120px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="%23f97316"><path d="M39.61 196.8L74.8 96.29C88.27 57.78 124.6 32 165.4 32H346.6c40.8 0 77.1 25.78 90.6 64.29l35.2 100.51c23.2 9.6 39.6 32.5 39.6 59.2v192c0 17.7-14.3 32-32 32h-32c-17.7 0-32-14.3-32-32v-48H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V256c0-26.7 16.4-49.6 39.6-59.2zM128 288c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32zm288 32c17.7 0 32-14.3 32-32s-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32z"/></svg>');
            background-repeat: no-repeat;
            opacity: 0.3;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background-color: rgba(30, 41, 59, 0.9);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.8s ease;
        }

        .login-header {
            padding: 25px;
            background-color: rgba(249, 115, 22, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .login-header h2 {
            color: var(--secondary);
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-header h2 i {
            margin-right: 10px;
            font-size: 28px;
        }

        .login-body {
            padding: 30px;
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group i.icon-prefix {
            position: absolute;
            left: 15px;
            top: 19px;
            color: var(--secondary);
            font-size: 18px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 19px;
            background: transparent;
            border: none;
            color: var(--secondary);
            cursor: pointer;
            font-size: 16px;
            opacity: 0.7;
            transition: var(--transition);
        }

        .toggle-password:hover {
            opacity: 1;
        }

        .form-input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius-sm);
            color: var(--white);
            font-size: 16px;
            transition: var(--transition);
        }

        .form-input.password {
            padding-right: 45px;
        }

        .form-input:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: var(--secondary);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius-sm);
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            background-color: var(--secondary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .btn i {
            margin-right: 8px;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius-sm);
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: var(--transition);
            font-size: 14px;
            font-weight: 500;
        }

        .back-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(-3px);
        }

        .back-btn i {
            margin-right: 6px;
        }

        .vintage-title {
            color: var(--white);
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 2px;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            position: relative;
            display: inline-block;
            font-family: 'Times New Roman', serif;
        }

        .vintage-title::before, .vintage-title::after {
            content: '';
            position: absolute;
            height: 3px;
            width: 60px;
            background-color: var(--secondary);
            top: 50%;
            transform: translateY(-50%);
        }

        .vintage-title::before {
            left: -80px;
        }

        .vintage-title::after {
            right: -80px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatCar {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .vintage-car, .vintage-car2 {
            animation: floatCar 6s ease-in-out infinite;
        }

        @media (max-width: 768px) {
            .vintage-title {
                font-size: 24px;
            }
            
            .vintage-title::before, .vintage-title::after {
                width: 30px;
            }
            
            .vintage-title::before {
                left: -40px;
            }
            
            .vintage-title::after {
                right: -40px;
            }
            
            .login-card {
                max-width: 90%;
            }
            
            .vintage-car, .vintage-car2 {
                display: none;
            }
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Back to Home
    </a>
    
    <div class="vintage-car"></div>
    <div class="vintage-car2"></div>
    
    <div class="login-container">
        <h1 class="vintage-title">REVGO ADMIN</h1>
        
        <?php if(isset($error_msg)): ?>
        <div class="error-message">
            <?php echo $error_msg; ?>
        </div>
        <?php endif; ?>
        
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-user-shield"></i> Admin Login</h2>
            </div>
            
            <div class="login-body">
                <form method="POST">
                    <div class="input-group">
                        <i class="fas fa-user icon-prefix"></i>
                        <input type="text" name="adid" class="form-input" placeholder="Admin ID" required>
                    </div>
                    
                    <div class="input-group">
                        <i class="fas fa-lock icon-prefix"></i>
                        <input type="password" name="adpass" id="password" class="form-input password" placeholder="Password" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                    
                    <button type="submit" name="adlog" class="btn">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>

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