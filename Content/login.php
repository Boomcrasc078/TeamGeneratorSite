<div style="display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto;
    gap: 10px;
    padding: 20px;
    margin: 0 auto;
    max-width: 1200px;">

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
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="form-group">
                <a href="register.php">Register</a>
            </div>
        </form>