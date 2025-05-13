<?php
include_once('imports.php');

// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mydatabase');

// Attempt to connect to MySQL database
$mysql_link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysql_link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Function to check if a user is logged in
function check_if_logged_in() {
    session_start();
    if (!isset($_SESSION['user'])) {
        redirect('login.php');
    }
}
?>