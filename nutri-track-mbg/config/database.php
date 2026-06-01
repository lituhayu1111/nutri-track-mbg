<?php
/**
 * Database Configuration
 * NUTRI TRACK MBG
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Kosong jika tidak ada password
define('DB_NAME', 'nutritrack_mbg');
define('DB_PORT', 3306);

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Store in variable for later use
$_SESSION['db'] = $conn;

// Return connection
return $conn;
?>