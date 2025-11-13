<?php
// Start the session
session_start();

// Set a logged out flag (will be used by index.php)
$_SESSION['logged_out'] = true;

// Unset all session variables
$_SESSION = array();

// If a session cookie is used, destroy it
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: index.php");
exit();
?> 