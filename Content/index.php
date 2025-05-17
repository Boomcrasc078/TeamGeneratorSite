<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';
?>

<?php
function logout_user(): void
{
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<div class="flex full-width full-height justify-center align-center">
    <div class="box-body" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 300px;">
        <h2>Welcome <?php echo $_SESSION['User']['Username']; ?> to TeamGeneratorSite</h2>
        <form method="post" action="">
            <input class="btn btn-primary" type="submit" name="logout" value="Logout">
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        logout_user();
    }
    ?>