<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';
?>

<?php
$activities = get_activities_from_user($_SESSION['User'])
?>

<?php
function add_activity($name): void
{
    global $database_link;

    $query = "INSERT INTO activities (Name, UserId) VALUES (?, ?)";
    $statement = mysqli_prepare($database_link, $query);
    mysqli_stmt_bind_param($statement, 'si', $name, $_SESSION['User']['UserId']);
    mysqli_stmt_execute($statement);
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_activity'])) {
    $name = 'new activity';
    add_activity($name);
    header('Location: activity.php');
    exit();
}
?>

<div class="flex full-width full-height justify-center align-center">
    <div class="box-body">
        <div class="flex" style="justify-content: space-between; align-items: center;">
            <h1>Activities</h1>
            <form method="post" action="activities.php">
                <button class="btn btn-primary" type="submit" name="add_activity">Add Activity</button>
            </form>
        </div>
        <div class="flex" style="flex-direction: column;">
            <?php
            foreach ($activities as $activity) { ?>
                <div class="box-body" style="width: auto;">
                    <h3><?php echo htmlspecialchars($activity['Name']); ?></h3>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>