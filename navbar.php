<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isset($_SESSION['email']) && !empty($_SESSION['email']);

// Fetch user data if logged in
$userData = null;
if ($isLoggedIn && isset($con)) {
    $email = $_SESSION['email'];
    $userQuery = "SELECT * FROM users WHERE EMAIL='$email'";
    $userResult = mysqli_query($con, $userQuery);
    if ($userResult) {
        $userData = mysqli_fetch_assoc($userResult);
    }
}
?>

<div class="navbar">
    <div class="container">
        <a href="<?php echo $isLoggedIn ? 'cardetails.php' : 'index.php'; ?>" class="logo">RevGo</a>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="menu">
            <ul>
                <li><a href="<?php echo $isLoggedIn ? 'cardetails.php' : 'index.php'; ?>"<?php if($currentPage == 'cardetails.php' || $currentPage == 'index.php') echo ' class="active"'; ?>><i class="fas fa-home"></i> Home</a></li>
                <li><a href="<?php echo $isLoggedIn ? 'aboutus2.html' : 'aboutus.html'; ?>"<?php if($currentPage == 'aboutus.html' || $currentPage == 'aboutus2.html') echo ' class="active"'; ?>><i class="fas fa-info-circle"></i> About</a></li>
                <li><a href="<?php echo $isLoggedIn ? 'contactus2.html' : 'contactus.html'; ?>"<?php if($currentPage == 'contactus.html' || $currentPage == 'contactus2.html') echo ' class="active"'; ?>><i class="fas fa-envelope"></i> Contact</a></li>
                
                <?php if($isLoggedIn): ?>
                <li><a href="feedback/Feedbacks.php"<?php if($currentPage == 'Feedbacks.php') echo ' class="active"'; ?>><i class="fas fa-comments"></i> Feedback</a></li>
                <li><a href="bookinstatus.php" class="book-status"<?php if($currentPage == 'bookinstatus.php') echo ' class="active"'; ?>><i class="fas fa-calendar-check"></i> Booking Status</a></li>
                <li>
                    <div class="user-profile">
                        <img src="images/profile.png" alt="User Profile">
                        <span class="user-name">Hello, <?php 
                            if ($userData && isset($userData['FNAME'])) {
                                echo $userData['FNAME'];
                            } elseif (isset($rows) && isset($rows['FNAME'])) {
                                echo $rows['FNAME'];
                            } else {
                                echo 'Guest';
                            }
                        ?></span>
                    </div>
                </li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
                <?php else: ?>
                <li><a href="adminlogin.php" class="adminbtn">Admin Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
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
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!menu.contains(event.target) && !menuToggle.contains(event.target) && menu.classList.contains('active')) {
            menu.classList.remove('active');
            menuToggle.classList.remove('active');
        }
    });
</script> 