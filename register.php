<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/TeamGeneratorSite/">
    <title>Register</title>
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
        <div class="flex full-width center">
            <div class="box-body">
                <form action="register_handler.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    <div class="form-group">
                        <a href="login.php">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
