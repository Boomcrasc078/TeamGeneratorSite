<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';

$user = $_SESSION['User'];
$username = $user['Username'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_username'])) {
        $new_username = trim($_POST['new_username'] ?? '');
        if ($new_username === '') {
            $error = 'Username cannot be empty.';
        } elseif ($new_username === $username) {
            $error = 'New username must be different.';
        } else {
            $result = change_user_username($user['UserId'], $new_username);
            if ($result === true) {
                // Refresh user session from database
                $user = get_user_by_username($new_username);
                $_SESSION['User'] = $user;
                $username = $new_username;
                $success = 'Username changed successfully!';
            } else {
                $error = $result;
            }
        }
    } elseif (isset($_POST['change_password'])) {
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        if ($new_password === '') {
            $error = 'Password cannot be empty.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'Passwords do not match.';
        } else {
            $result = change_user_password($user['UserId'], $new_password);
            if ($result === true) {
                $success = 'Password changed successfully!';
            } else {
                $error = $result;
            }
        }
    }
}
?>
<div class="flex full-width full-height justify-center align-center">
    <div class="box-body" style="min-width:320px;">
        <h2>Profile</h2>
        <?php if ($error): ?>
            <div class="form-group"><p style="color:red;"> <?= htmlspecialchars($error) ?> </p></div>
        <?php elseif ($success): ?>
            <div class="form-group"><p style="color:green;"> <?= htmlspecialchars($success) ?> </p></div>
        <?php endif; ?>
        <form method="post" action="" style="margin-bottom:24px;">
            <div class="form-group">
                <label for="new_username">Username</label>
                <input type="text" class="form-control" id="new_username" name="new_username" value="<?= htmlspecialchars($username) ?>" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="change_username">Change Username</button>
            </div>
        </form>
        <form method="post" action="">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="change_password">Change Password</button>
            </div>
        </form>
    </div>
</div>
