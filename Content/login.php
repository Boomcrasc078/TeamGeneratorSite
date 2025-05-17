<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';
?>

<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$error = '';
function submit_form()
{
    global $error, $username, $password;
    if (empty($username)) {
        $error = 'Username cannot be empty.';
    }
    if (empty($password)) {
        $error = 'Password cannot be empty.';
    }

    if (empty($error)) {

        $login_status = try_login_user(username: $username, password: $password);

        if ($login_status) {
            header(header: 'Location: index.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    submit_form();
} else {
    $error = '';
}

?>

<div class="flex full-width full-height justify-center align-center">
    <div class="box-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php if (isset($error) && !empty($error)): ?>
                <div class="form-group">
                    <p style="color: red;"> <?= htmlspecialchars($error) ?> </p>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="form-group">
                <a href="register.php" class="btn btn-secondary">Don't have an account? Register</a>
            </div>
        </form>
    </div>
</div>