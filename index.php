<?php
session_start();
include_once 'functions.php';

// Kontrollera om användaren är inloggad
check_if_logged_in();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/TeamGeneratorSite/">
    <title>TeamGeneratorSite</title>
    <?php include_once 'imports.php'; ?>
    <link rel="stylesheet" href="Layout/layout.css">
</head>

<body>
    <div class="sidebar">
        <?php include("Layout/sidebar.php"); ?>
    </div>
    <div class="topbar">
        <!-- Topbar content can be added here -->
    </div>
    <div class="content">
        <?php include_once 'Content/index.php'; ?>
    </div>
</body>

</html>