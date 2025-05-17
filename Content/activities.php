<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';
?>

<?php
$activities = get_activities_from_user($_SESSION['User'])
    ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_activity'])) {
    $name = 'new activity';
    $activity = add_activity($name);
    header('Location: activity.php?activity=' . urlencode($activity['PublicKey']));
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
                <a class="box-body" style="width: auto;"
                    href="activity.php?activity=<?php echo urlencode($activity['PublicKey']); ?>">
                    <h3><?php echo htmlspecialchars($activity['Name']); ?></h3>
                </a>
                <?php
            }
            ?>

        </div>
    </div>
</div>