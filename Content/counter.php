<?php
include_once 'Backend/imports.php';
include_once 'Backend/web.php';
include_once 'Backend/database.php';

$publicKey = $_GET['activity'] ?? '';
$activity = get_activity_by_public_key($publicKey);
if (!$activity) {
    header('Location: activities.php');
    exit();
}

// Hämta lag och poäng
$teams = $activity['Data']['teams'] ?? [];
$scores = $activity['Data']['scores'] ?? array_fill(0, count($teams), 0);

// Hantera poänguppdatering via POST (AJAX eller form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scores'])) {
    $scores = array_map('intval', $_POST['scores']);
    $activity['Data']['scores'] = $scores;
    save_activity_data($activity['PublicKey'], $activity['Data']);
    echo 'OK';
    exit();
}

// Hantera anteckningar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notes'])) {
    $activity['Data']['notes'] = $_POST['notes'];
    save_activity_data($activity['PublicKey'], $activity['Data']);
    echo 'OK';
    exit();
}
?>
<div class="flex full-width justify-center align-center" style="flex-direction: column;">
    <div class="stopwatch box-body" style="margin-bottom: 24px; text-align: center;">
        <span id="stopwatch-time" style="font-size:2em;">00:00:00</span><br>
        <br />
        <button class="btn btn-primary" onclick="startStopwatch()" id="startBtn">Start</button>
        <button class="btn btn-secondary" onclick="stopStopwatch()" id="stopBtn" disabled>Stop</button>
        <button class="btn btn-secondary" onclick="resetStopwatch()">Reset</button>
    </div>
    <div class="box-accent">
        <h2 style="text-align:center;">Team Scores</h2>
        <form id="scoreForm">
            <div class="flex" style="flex-wrap: wrap; gap: 24px; justify-content: center;">
                <?php foreach ($teams as $i => $team): ?>
                    <div class="box-body team-box" style="min-width:220px; text-align:center;">
                        <h3>Team <?= $i+1 ?></h3>
                        <ul style="list-style:none; padding:0;">
                            <?php foreach ($team as $member): ?>
                                <li><?= htmlspecialchars($member) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="score-controls" style="margin-top:10px; display:flex; justify-content:center; align-items:center; gap:10px;">
                            <button type="button" class="score-btn btn btn-secondary" onclick="updateScore(<?= $i ?>, -1)">-</button>
                            <span class="score-value" id="score-<?= $i ?>"><?= $scores[$i] ?? 0 ?></span>
                            <button type="button" class="score-btn btn btn-secondary" onclick="updateScore(<?= $i ?>, 1)">+</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
    <div style="margin-top: 30px; text-align: center;">
        <a class="btn btn-secondary" href="activity.php?activity=<?= urlencode($activity['PublicKey']) ?>">Tillbaka till aktivitet</a>
    </div>
    <div class="box-body">
        <h3>Anteckningar</h3>
        <form id="notesForm" method="post" action="">
            <div class="form-group">
                <textarea name="notes" id="notes" rows="5" class="form-control" placeholder="Skriv anteckningar här..." ><?= htmlspecialchars($activity['Data']['notes'] ?? '') ?></textarea>
            </div>
        </form>
    </div>
</div>
<script>
    // Stopwatch logic
    let stopwatchInterval = null;
    let elapsed = 0;
    function updateStopwatchDisplay() {
        let h = Math.floor(elapsed / 3600).toString().padStart(2, '0');
        let m = Math.floor((elapsed % 3600) / 60).toString().padStart(2, '0');
        let s = (elapsed % 60).toString().padStart(2, '0');
        document.getElementById('stopwatch-time').textContent = `${h}:${m}:${s}`;
    }
    function startStopwatch() {
        if (stopwatchInterval) return;
        stopwatchInterval = setInterval(() => {
            elapsed++;
            updateStopwatchDisplay();
        }, 1000);
        document.getElementById('startBtn').disabled = true;
        document.getElementById('stopBtn').disabled = false;
    }
    function stopStopwatch() {
        clearInterval(stopwatchInterval);
        stopwatchInterval = null;
        document.getElementById('startBtn').disabled = false;
        document.getElementById('stopBtn').disabled = true;
    }
    function resetStopwatch() {
        stopStopwatch();
        elapsed = 0;
        updateStopwatchDisplay();
    }
    updateStopwatchDisplay();

    // Score logic
    let scores = <?php echo json_encode($scores); ?>;
    function updateScore(idx, delta) {
        scores[idx] = (scores[idx] || 0) + delta;
        if (scores[idx] < 0) scores[idx] = 0;
        document.getElementById('score-' + idx).textContent = scores[idx];
        saveScores();
    }
    function saveScores() {
        const formData = new FormData();
        scores.forEach((score, i) => formData.append('scores['+i+']', score));
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        });
    }

    // Spara anteckningar automatiskt
    const notesTextarea = document.getElementById('notes');
    if (notesTextarea) {
        let notesTimeout = null;
        notesTextarea.addEventListener('input', function() {
            clearTimeout(notesTimeout);
            notesTimeout = setTimeout(() => {
                const formData = new FormData();
                formData.append('notes', notesTextarea.value);
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                });
            }, 600);
        });
    }
</script>
