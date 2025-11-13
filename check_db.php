<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Database Structure for '$dbname'</h2>";

// Get all tables
$result = $conn->query("SHOW TABLES");

if ($result->num_rows > 0) {
    echo "<h3>Tables:</h3>";
    echo "<ul>";
    while($row = $result->fetch_row()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No tables found in the database.</p>";
}

// Close connection
$conn->close();
?> 