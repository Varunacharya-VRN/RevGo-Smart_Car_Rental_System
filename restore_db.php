<?php
// Display all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Restoration Tool</h2>";

// Connect to MySQL server (without selecting a database)
$conn = new mysqli('localhost', 'root', '');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<p>Connected to MySQL server successfully.</p>";

// Check if database exists, drop it if it does
$result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'carproject'");
if ($result->num_rows > 0) {
    echo "<p>Dropping existing 'carproject' database...</p>";
    if ($conn->query("DROP DATABASE carproject")) {
        echo "<p>Existing database dropped successfully.</p>";
    } else {
        die("Error dropping database: " . $conn->error);
    }
}

// Create fresh database
echo "<p>Creating fresh 'carproject' database...</p>";
if ($conn->query("CREATE DATABASE carproject")) {
    echo "<p>Database created successfully.</p>";
} else {
    die("Error creating database: " . $conn->error);
}

// Close the connection
$conn->close();

// Now import the SQL file
$sqlFile = 'database/carproject.sql';

if (!file_exists($sqlFile)) {
    die("Error: SQL file not found at {$sqlFile}");
}

echo "<p>Importing SQL file: {$sqlFile}</p>";

// Use the mysql command to import the SQL file
$command = "mysql -u root carproject < " . escapeshellarg(realpath($sqlFile));

// For Windows, we might need to specify the path to mysql.exe
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $xamppPath = "C:\\xampp\\mysql\\bin\\";
    $command = $xamppPath . "mysql -u root carproject < " . escapeshellarg(realpath($sqlFile));
}

// Execute the command
$output = [];
$returnVar = 0;
exec($command, $output, $returnVar);

if ($returnVar !== 0) {
    echo "<p>Error executing MySQL import command. Return code: {$returnVar}</p>";
    echo "<p>Command output:</p><pre>" . implode("\n", $output) . "</pre>";
    
    // Alternative method using PHP to import SQL
    echo "<p>Trying alternative import method...</p>";
    
    try {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'carproject');
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Read the SQL file
        $sql = file_get_contents($sqlFile);
        
        // Split SQL file into individual statements
        $statements = explode(';', $sql);
        
        // Execute each statement
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                if (!$conn->query($statement . ';')) {
                    throw new Exception("Error executing SQL: " . $conn->error);
                }
            }
        }
        
        echo "<p>Database restored successfully using alternative method!</p>";
        $conn->close();
    } catch (Exception $e) {
        echo "<p>Error during alternative import: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Database restored successfully!</p>";
}

echo "<p><a href='index.php'>Go to homepage</a></p>";
?> 