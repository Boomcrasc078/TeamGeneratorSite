<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/TeamGeneratorSite/">
    <title>TeamGeneratorSite</title>
    <?php include_once 'Backend/imports.php'; ?>
    <?php include_once 'Backend/web.php'; ?>
    <?php include_once 'Backend/database.php'; ?>
    <link rel="stylesheet" href="Layout/layout.css">
</head>

<body>
    <?php var_dump(value: get_all_users()); ?>
</body>

</html>