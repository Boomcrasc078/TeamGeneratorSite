<?php
include_once('imports.php');

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mydatabase');

/* Attempt to connect to MySQL database */
$mysql_link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysql_link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($mysql_link) {
    $sql = "SELECT * FROM users";

    $resultat = mysqli_query($mysql_link, $sql);

    debug_to_console($resultat);
}

?>

<?php

function check_if_logged_in()
{
    session_start();
    if (!isset($_SESSION['user'])) {
        redirect('login.php');
    }
}

?>