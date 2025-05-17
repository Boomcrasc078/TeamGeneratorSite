<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/TeamGeneratorSite/">
    <title>Team Counter</title>
    <?php include_once 'Backend/imports.php'; ?>
    <link rel="stylesheet" href="Layout/layout.css">
</head>
<body>
    <div class="sidebar">
        <?php include_once("Layout/sidebar.php"); ?>
    </div>
    <div class="topbar">
        <?php include_once("Layout/topbar.php"); ?>
    </div>
    <div class="content">
        <?php include_once 'Content/counter.php'; ?>
    </div>
</body>
</html>
