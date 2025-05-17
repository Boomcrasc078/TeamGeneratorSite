<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';
?>

<?php
function update_name()
{
    global $activity;

    $new_name = trim($_POST['name']);
    if ($new_name !== '' && $new_name !== $activity['Name']) {
        update_activity_name($activity['PublicKey'], $new_name);
        $activity = get_activity_by_public_key($activity['PublicKey']);
    }
}

// Funktion för att dela upp namn i lag
function split_into_teams($names, $team_count = null, $team_size = null) {
    $names = array_filter(array_map('trim', explode("\n", $names)));
    shuffle($names);

    $teams = [];
    if ($team_count && $team_count > 0) {
        $teams = array_fill(0, $team_count, []);
        foreach ($names as $i => $name) {
            $teams[$i % $team_count][] = $name;
        }
    } elseif ($team_size && $team_size > 0) {
        $team_count = ceil(count($names) / $team_size);
        $teams = array_fill(0, $team_count, []);
        foreach ($names as $i => $name) {
            $teams[floor($i / $team_size)][] = $name;
        }
    }
    return $teams;
}
?>

<?php
$activity = get_activity_by_public_key($_GET['activity'] ?? '');

if ($activity === null) {
    header('Location: activities.php');
    exit();
}

// Hantera POST för namnändring eller borttagning
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        delete_activity($activity['PublicKey']);
        header('Location: activities.php');
        exit();
    } elseif (isset($_POST['name'])) {
        update_name();
    }
}

// Hantera POST för laguppdelning
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Använd alltid POST-data om det finns
    $member_names = $_POST['member_names'] ?? '';
    $team_count = isset($_POST['team_count']) && $_POST['team_count'] !== '' ? intval($_POST['team_count']) : null;
    $team_size = isset($_POST['team_size']) && $_POST['team_size'] !== '' ? intval($_POST['team_size']) : null;
} else {
    // Annars använd sparade data
    $member_names = $activity['Data']['member_names'] ?? '';
    $team_count = $activity['Data']['team_count'] ?? null;
    $team_size = $activity['Data']['team_size'] ?? null;
}

$teams = $activity['Data']['teams'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!empty($member_names) && ($team_count || $team_size))) {
    $teams = split_into_teams($member_names, $team_count, $team_size);

    // Spara all data i Data-fältet i databasen
    $data = [
        'team_count' => $team_count,
        'team_size' => $team_size,
        'member_names' => $member_names,
        'teams' => $teams
    ];
    save_activity_data($activity['PublicKey'], $data);

    // Uppdatera $activity['Data'] så att sidan visar rätt direkt
    $activity['Data'] = $data;
} elseif ($_SERVER['REQUEST_METHOD'] !== 'POST' && !empty($activity['Data'])) {
    // För GET, ladda teams från Data om det finns
    $teams = $activity['Data']['teams'] ?? [];
}
?>

<div class="flex full-width justify-center align-center" style="flex-direction: column;">
    <div class="box-body">
        <form method="post" action="" id="activity-name-form">
            <div class="form-group">
                <label for="name">Activity Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo htmlspecialchars($activity['Name']); ?>"
                    onchange="document.getElementById('activity-name-form').submit();">
                </input>
            </div>
        </form>
        <form method="post" action="" id="activity-delete-form" style="margin-top: 10px;">
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="delete">Delete Activity</button>
            </div>
        </form>
    </div>
    <div class="box-body">
        <h2>Options</h2>
        <form method="post" action="activity.php?activity=<?= urlencode($activity['PublicKey']) ?>">
            <div class="form-group">
                <label for="team_count">Team Count</label>
                <input type="number" accept="number" min="1" max="100" name="team_count" id="team_count"
                    placeholder="Team Count" value="<?= htmlspecialchars($team_count ?? '') ?>"
                    oninput="if(this.value) document.getElementById('team_size').value='';">
            </div>
            <div class="form-group">
                <label for="team_size">Team Size</label>
                <input type="number" accept="number" min="1" max="100" name="team_size" id="team_size"
                    placeholder="Team Size" value="<?= htmlspecialchars($team_size ?? '') ?>"
                    oninput="if(this.value) document.getElementById('team_count').value='';">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Generate Teams</button>
            </div>
            <div class="form-group">
                <label for="member_names">Team Members (one per line)</label>
                <textarea id="member_names" name="member_names" rows="8" class="form-control" placeholder="Enter one name per line"><?= htmlspecialchars($member_names) ?></textarea>
            </div>
        </form>
    </div>
    <?php if (!empty($teams)): ?>
    <div class="box-accent">
        <h2>Teams</h2>
        <div class="flex" style="flex-wrap: wrap; gap: 16px;">
            <?php foreach ($teams as $i => $team): ?>
                <div class="box-body" style="min-width: 120px;">
                    <h3>Team <?= $i + 1 ?></h3>
                    <ul>
                        <?php foreach ($team as $member): ?>
                            <li><?= htmlspecialchars($member) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <div style="margin-top: 30px; text-align: center;">
        <a class="btn btn-primary" href="counter.php?activity=<?= urlencode($activity['PublicKey']) ?>">Gå till Poängräknare</a>
    </div>
</div>
</div>