<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RevGo | Registration</title>
    <link rel="stylesheet" href="css/navbar.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("images/jamie-street.jpg");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #fff;
        }
        
        .register-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        
        .register-card {
            max-width: 900px;
            width: 100%;
            background: rgba(18, 25, 44, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            padding: 40px;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            background: linear-gradient(90deg, #f97316, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .register-header p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .form-col {
            flex: 1;
            min-width: 250px;
        }
        
        .gender-options {
            display: flex;
            gap: 30px;
            margin-top: 10px;
        }
        
        .gender-option {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .gender-option input[type="radio"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .btn-submit {
            background: linear-gradient(90deg, #f97316, #3b82f6);
            color: #fff;
            border: none;
            padding: 14px 25px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.4);
        }
        
        .home-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            background: rgba(249, 115, 22, 0.2);
            border: 1px solid #f97316;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .home-link:hover {
            background: linear-gradient(90deg, #f97316, #3b82f6);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(249, 115, 22, 0.4);
        }
        
        .password-requirements {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .password-requirements h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #fff;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            margin: 8px 0;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .requirement i {
            margin-right: 10px;
            font-size: 14px;
        }
        
        .requirement.valid i {
            color: #22c55e;
        }
        
        .requirement.invalid i {
            color: #ef4444;
        }
        
        .info-text {
            text-align: center;
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }
        
        .info-text a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        
        .info-text a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .register-card {
                padding: 25px;
            }
            
            .register-header h1 {
                font-size: 2rem;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    
<?php

require_once('connection.php');
if(isset($_POST['regs']))
{
    $fname=mysqli_real_escape_string($con,$_POST['fname']);
    $lname=mysqli_real_escape_string($con,$_POST['lname']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $lic=mysqli_real_escape_string($con,$_POST['lic']);
    $ph=mysqli_real_escape_string($con,$_POST['ph']);
   
    $pass=mysqli_real_escape_string($con,$_POST['pass']);
    $cpass=mysqli_real_escape_string($con,$_POST['cpass']);
    $gender=mysqli_real_escape_string($con,$_POST['gender']);
    $Pass=md5($pass);
    if(empty($fname)|| empty($lname)|| empty($email)|| empty($lic)|| empty($ph)|| empty($pass) || empty($gender))
    {
        echo '<script>alert("please fill the place")</script>';
    }
    else{
        if($pass==$cpass){
        $sql2="SELECT *from users where EMAIL='$email'";
        $res=mysqli_query($con,$sql2);
        if(mysqli_num_rows($res)>0){
            echo '<script>alert("EMAIL ALREADY EXISTS PRESS OK FOR LOGIN!!")</script>';
            echo '<script> window.location.href = "index.php";</script>';

        }
        else{
        $sql="insert into users (FNAME,LNAME,EMAIL,LIC_NUM,PHONE_NUMBER,PASSWORD,GENDER) values('$fname','$lname','$email','$lic',$ph,'$Pass','$gender')";
        $result = mysqli_query($con,$sql);
        if($result){
            echo '<script>alert("Registration Successful Press ok to login")</script>';
            echo '<script> window.location.href = "index.php";</script>';       
           }
        else{
            echo '<script>alert("please check the connection")</script>';
        }
    
        }

        }
        else{
            echo '<script>alert("PASSWORD DID NOT MATCH")</script>';
            echo '<script> window.location.href = "register.php";</script>';
        }
    }
}


?>

    <div class="navbar">
        <div class="container">
            <a href="index.php" class="logo">RevGo</a>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="aboutus.html"><i class="fas fa-info-circle"></i> About</a></li>
                    <li><a href="contactus.html"><i class="fas fa-envelope"></i> Contact</a></li>
                    <li><a href="adminlogin.php" class="adminbtn">Admin Login</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h1>Join Our Family</h1>
                <p>Create your account to start renting premium vehicles</p>
            </div>
        
            <form id="registerForm" action="register.php" method="POST">
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter your first name" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" id="lname" class="form-control" placeholder="Enter your last name" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address" required>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="lic">License Number</label>
                            <input type="text" name="lic" id="lic" class="form-control" placeholder="Enter your license number" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="ph">Phone Number</label>
                            <input type="tel" name="ph" id="ph" class="form-control" placeholder="Enter your phone number" maxlength="10" onkeypress="return onlyNumberKey(event)" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="psw">Password</label>
                            <input type="password" name="pass" id="psw" class="form-control" placeholder="Create a password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 characters" maxlength="12" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="cpsw">Confirm Password</label>
                            <input type="password" name="cpass" id="cpsw" class="form-control" placeholder="Confirm your password" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Gender</label>
                    <div class="gender-options">
                        <div class="gender-option">
                            <input type="radio" id="male" name="gender" value="male" required>
                            <label for="male">Male</label>
                        </div>
                        <div class="gender-option">
                            <input type="radio" id="female" name="gender" value="female" required>
                            <label for="female">Female</label>
                        </div>
                    </div>
                </div>
                
                <div class="password-requirements">
                    <h3>Password must contain:</h3>
                    <div class="requirement invalid" id="letter">
                        <i class="fas fa-times-circle"></i>
                        <span>At least one lowercase letter</span>
                    </div>
                    <div class="requirement invalid" id="capital">
                        <i class="fas fa-times-circle"></i>
                        <span>At least one uppercase letter</span>
                    </div>
                    <div class="requirement invalid" id="number">
                        <i class="fas fa-times-circle"></i>
                        <span>At least one number</span>
                    </div>
                    <div class="requirement invalid" id="length">
                        <i class="fas fa-times-circle"></i>
                        <span>Minimum of 8 characters</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit" name="regs">Register Account</button>
            </form>
            
            <p class="info-text">Already have an account? <a href="index.php">Login here</a></p>
        </div> 
    </div>

<script>
        // Password validation
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
                letter.querySelector("i").classList.remove("fa-times-circle");
                letter.querySelector("i").classList.add("fa-check-circle");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
                letter.querySelector("i").classList.remove("fa-check-circle");
                letter.querySelector("i").classList.add("fa-times-circle");
}

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
                capital.querySelector("i").classList.remove("fa-times-circle");
                capital.querySelector("i").classList.add("fa-check-circle");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
                capital.querySelector("i").classList.remove("fa-check-circle");
                capital.querySelector("i").classList.add("fa-times-circle");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
                number.querySelector("i").classList.remove("fa-times-circle");
                number.querySelector("i").classList.add("fa-check-circle");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
                number.querySelector("i").classList.remove("fa-check-circle");
                number.querySelector("i").classList.add("fa-times-circle");
  }

  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
                length.querySelector("i").classList.remove("fa-times-circle");
                length.querySelector("i").classList.add("fa-check-circle");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
                length.querySelector("i").classList.remove("fa-check-circle");
                length.querySelector("i").classList.add("fa-times-circle");
  }
}

        // Allow only numbers in phone number field
    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
        
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