<?php
session_start();
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}
?>