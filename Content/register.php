<?php
include_once('Backend/imports.php');
include_once('Backend/web.php');
?>

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