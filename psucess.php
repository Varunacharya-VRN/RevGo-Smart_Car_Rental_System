<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

            body {
                text-align: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/ps.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            filter: blur(8px);
            z-index: -1;
            transform: scale(1.1); /* Prevents blur edge artifacts */
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 90%;
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 0.8s ease forwards;
            z-index: 1;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .check-container {
            border-radius: 50%;
            height: 150px;
            width: 150px;
            background: #f8faf5;
            margin: 0 auto 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .checkmark {
            color: #4CAF50;
            font-size: 80px;
            opacity: 0;
            transform: scale(0);
            animation: check 0.8s ease forwards 0.4s;
        }

        @keyframes check {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        h1 {
            color: #3a7bd5;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 36px;
            margin-bottom: 16px;
            opacity: 0;
            animation: fadeIn 0.8s ease forwards 0.6s;
        }

        p {
            color: #555;
            font-family: 'Poppins', sans-serif;
                font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0;
            animation: fadeIn 0.8s ease forwards 0.8s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #ff7200, #ff5500);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
                text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 114, 0, 0.3);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.8s ease forwards 1s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 114, 0, 0.4);
            }

        .btn:active {
            transform: translateY(1px);
            }
            </style>
</head>
    <body>
      <div class="card">
        <div class="check-container">
            <span class="checkmark">✓</span>
      </div>
        <h1>Success!</h1>
        <p>We received your rental request.<br>Our team will be in touch with you shortly!</p>
        <a href="cardetails.php" class="btn">Search More Cars</a>
      </div>
    </body>
</html>
