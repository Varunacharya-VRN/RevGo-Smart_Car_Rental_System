<?php
require_once('connection.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}

$query = "select * from feedback";
$queryy = mysqli_query($con, $query);
$num = mysqli_num_rows($queryy);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RevGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --navbar-radius: 0 0 15px 15px;
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
            color: var(--white);
        }

        .dashboard-container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background-color: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-lg);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-brand {
            color: var(--secondary);
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .logo-brand:hover {
            transform: scale(1.05);
        }

        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 24px;
            margin-right: 15px;
        }

        .nav-menu {
            list-style: none;
            margin-bottom: auto;
        }

        .nav-item {
            margin-bottom: 8px;
            border-radius: var(--border-radius-sm);
            transition: background-color 0.3s ease;
        }

        .nav-item.active {
            background-color: rgba(249, 115, 22, 0.15);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--gray-200);
            text-decoration: none;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-item.active .nav-link {
            color: var(--secondary);
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 18px;
            min-width: 25px;
            text-align: center;
        }

        .logout-btn {
            margin-top: 20px;
            background-color: rgba(249, 115, 22, 0.15);
            border: none;
            padding: 12px 15px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            color: var(--secondary);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background-color: var(--secondary);
            color: var(--white);
        }

        .logout-btn i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
            transition: margin-left 0.3s ease-in-out;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.8s ease;
        }

        .page-title {
            font-size: 26px;
            font-weight: 600;
            color: var(--white);
            display: flex;
            align-items: center;
        }

        .page-title i {
            margin-right: 10px;
            background-color: rgba(249, 115, 22, 0.2);
            padding: 10px;
            border-radius: 50%;
            color: var(--secondary);
        }

        .card {
            background-color: rgba(30, 41, 59, 0.8);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .card-header {
            padding: 20px;
            background-color: rgba(249, 115, 22, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--secondary);
    display: flex;
    align-items: center;
}

        .card-title i {
            margin-right: 10px;
        }

        .data-count {
            background-color: var(--secondary);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
    font-size: 14px;
            font-weight: 500;
        }

        .table-responsive {
            overflow-x: auto;
            padding: 0 5px;
        }

        .data-table {
            width: 100%;
   border-collapse: collapse;
            margin-top: 5px;
            color: var(--gray-200);
        }

        .data-table thead th {
            background-color: rgba(30, 41, 59, 0.5);
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(249, 115, 22, 0.5);
        }

        .data-table tbody tr {
            transition: var(--transition);
            animation: fadeIn 0.5s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .data-table tbody tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .data-table tbody tr:hover {
            background-color: rgba(249, 115, 22, 0.05);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .data-table td {
            padding: 15px 20px;
            font-size: 14px;
        }

        .data-table .highlight {
            color: var(--secondary);
            font-weight: 500;
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            color: var(--gray-200);
            font-style: italic;
        }

        .comment-text {
            max-width: 350px;
    overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .comment-text:hover {
            white-space: normal;
            background-color: rgba(0, 0, 0, 0.7);
            position: absolute;
            padding: 10px;
            border-radius: var(--border-radius-sm);
            z-index: 10;
            box-shadow: var(--shadow-md);
            max-width: 500px;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: rgba(30, 41, 59, 0.8);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 20px;
            display: flex;
            flex-direction: column;
            animation: fadeInUp 0.5s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            background-color: rgba(30, 41, 59, 0.9);
        }

        .stat-icon {
            margin-bottom: 15px;
            align-self: flex-start;
            width: 50px;
            height: 50px;
            background-color: rgba(249, 115, 22, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--secondary);
        }

        .stat-card:nth-child(2) .stat-icon {
            background-color: rgba(37, 99, 235, 0.2);
            color: var(--primary);
        }

        .stat-card:nth-child(3) .stat-icon {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--white);
        }

        .stat-title {
            font-size: 14px;
            color: var(--gray-200);
            letter-spacing: 0.5px;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .data-table thead {
                display: none;
            }

            .data-table, 
            .data-table tbody, 
            .data-table tr, 
            .data-table td {
                display: block;
                width: 100%;
            }

            .data-table tr {
                margin-bottom: 15px;
                border-bottom: 2px solid rgba(249, 115, 22, 0.2);
            }

            .data-table td {
                text-align: right;
                padding: 10px 15px;
                position: relative;
                padding-left: 50%;
            }

            .data-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 50%;
                text-align: left;
                font-weight: 600;
                color: var(--secondary);
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        .feedback-row:nth-child(1) { animation-delay: 0.1s; }
        .feedback-row:nth-child(2) { animation-delay: 0.2s; }
        .feedback-row:nth-child(3) { animation-delay: 0.3s; }
        .feedback-row:nth-child(4) { animation-delay: 0.4s; }
        .feedback-row:nth-child(5) { animation-delay: 0.5s; }
        
        #overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
}
</style>
</head>
<body>
    <div id="overlay"></div>
    
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="#" class="logo-brand">RevGo</a>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="adminvehicle.php" class="nav-link">
                        <i class="fas fa-car"></i>
                        <span>Vehicle Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="adminusers.php" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="admindash.php" class="nav-link">
                        <i class="fas fa-comments"></i>
                        <span>Feedbacks</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="adminbook.php" class="nav-link">
                        <i class="fas fa-calendar-check"></i>
                        <span>Booking Requests</span>
                    </a>
                </li>
                </ul>
            
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
        
        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <div class="page-header">
                <div class="page-title">
                    <i class="fas fa-comments animate-pulse"></i>
                    <span>Feedback Management</span>
                </div>
                <div class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-number"><?php echo $num; ?></div>
                    <div class="stat-title">TOTAL FEEDBACKS</div>
                </div>
                
                <div class="stat-card">
                    <?php
                    // Get user count
                    $userQuery = "SELECT COUNT(*) as user_count FROM users";
                    $userResult = mysqli_query($con, $userQuery);
                    $userCount = 0;
                    if ($userResult) {
                        $userRow = mysqli_fetch_assoc($userResult);
                        $userCount = $userRow['user_count'];
                    }
                    ?>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number"><?php echo $userCount; ?></div>
                    <div class="stat-title">REGISTERED USERS</div>
                </div>
                
                <div class="stat-card">
                    <?php
                    // Get booking count
                    $bookingQuery = "SELECT COUNT(*) as booking_count FROM booking";
                    $bookingResult = mysqli_query($con, $bookingQuery);
                    $bookingCount = 0;
                    if ($bookingResult) {
                        $bookingRow = mysqli_fetch_assoc($bookingResult);
                        $bookingCount = $bookingRow['booking_count'];
                    }
                    ?>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-number"><?php echo $bookingCount; ?></div>
                    <div class="stat-title">TOTAL BOOKINGS</div>
                </div>
            </div>
            
            <!-- Feedback Table Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-comments"></i>
                        <span>Customer Feedbacks</span>
                    </div>
                    <div class="data-count"><?php echo $num; ?> Entries</div>
                </div>
                
                <div class="table-responsive">
                    <?php if ($num > 0) { ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($res = mysqli_fetch_array($queryy)) { ?>
                            <tr class="feedback-row">
                                <td data-label="ID" class="highlight"><?php echo $res['FED_ID']; ?></td>
                                <td data-label="Email"><?php echo $res['EMAIL']; ?></td>
                                <td data-label="Comment">
                                    <div class="comment-text"><?php echo $res['COMMENT']; ?></div>
                                </td>
                                <td data-label="Date">
                                    <?php 
                                    // If there's a date column, show it; otherwise show a placeholder
                                    echo isset($res['CREATED_AT']) ? $res['CREATED_AT'] : date('Y-m-d');
                                    ?>
                                </td>
                </tr>
               <?php } ?>
                </tbody>
                </table>
                    <?php } else { ?>
                    <div class="empty-message">
                        <p>No feedbacks available at the moment.</p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.getElementById('main-content');
        
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        });
        
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.style.display = 'none';
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('active');
                overlay.style.display = 'none';
            }
        });
        
        // Add animation to table rows
        document.querySelectorAll('.feedback-row').forEach((row, index) => {
            row.style.animationDelay = `${0.1 * (index + 1)}s`;
        });
        
        // Expandable comments
        document.querySelectorAll('.comment-text').forEach(comment => {
            comment.addEventListener('click', function() {
                this.classList.toggle('expanded');
            });
        });
    </script>
</body>
</html>