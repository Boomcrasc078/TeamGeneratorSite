<?php
include_once 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($mysql_link, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $username, $hashed_password);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: login.php');
            exit();
        } else {
            die('Error: Could not execute query.');
        }
        mysqli_stmt_close($stmt);
    } else {
        die('Error: Could not prepare statement.');
    }
}
?>
