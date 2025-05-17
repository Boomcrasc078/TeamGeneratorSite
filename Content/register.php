<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';
?>

<?php
function check_password_confirmed($password, $confirm_password): bool
{
    return $password === $confirm_password;
}


?>

<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$error = '';

function submit_form()
{
    global $username, $password, $confirm_password, $error;

    if (!check_password_confirmed(password: $password, confirm_password: $confirm_password)) {
        $error = 'Passwords do not match.';
    }

    if (empty($password)) {
        $error = 'Password cannot be empty.';
    }

    if (empty($username)) {
        $error = 'Username cannot be empty.';
    }
    if (empty($error)) {
        $registration_result = register_user($username, $password);

        if ($registration_result !== true) {
            $error = $registration_result;
        }
    }
    if (empty($error)) {
        $login_status = try_login_user(username: $username, password: $password);

        if ($login_status) {
            header(header: 'Location: index.php');
            exit();
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
        <form action="register.php" method="post">
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
            <?php if (isset($error) && !empty($error)): ?>
                <div class="form-group">
                    <p style="color: red;"> <?= htmlspecialchars($error) ?> </p>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
            <div class="form-group">
                <a class="btn btn-secondary" href="login.php">Already have an account? Login</a>
            </div>
        </form>
    </div>
</div>