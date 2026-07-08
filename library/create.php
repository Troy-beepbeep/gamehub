<?php
$pageTitle = "Add to Library";
require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

$games = $conn->query("SELECT id, title FROM games ORDER BY title ASC");
$players = $conn->query("SELECT id, display_name FROM player_profiles ORDER BY display_name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_profile_id = (int) $_POST['player_profile_id'];
    $game_id = (int) $_POST['game_id'];
    $hours_played = (int) $_POST['hours_played'];
    $date_added = $_POST['date_added'];
    $is_favorite = (int) $_POST['is_favorite'];

    // Cek duplikat karena ada UNIQUE(player_profile_id, game_id)
    $check = $conn->prepare("SELECT id FROM game_library WHERE player_profile_id = ? AND game_id = ?");
    $check->bind_param("ii", $player_profile_id, $game_id);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        $error = "Pemain ini sudah memiliki game tersebut di library!";
    } else {
        $stmt = $conn->prepare("INSERT INTO game_library (player_profile_id, game_id, hours_played, date_added, is_favorite) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisi", $player_profile_id, $game_id, $hours_played, $date_added, $is_favorite);
        $stmt->execute();
        header("Location: index.php?success=add");
        exit;
    }
}
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="bi bi-plus-circle-fill"></i> Add to Library</h2>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Player</label>
                    <select name="player_profile_id" class="form-select" required>
                        <option value="">-- Pilih Player --</option>
                        <?php while($player = $players->fetch_assoc()): ?>
                            <option value="<?= $player['id']; ?>"><?= htmlspecialchars($player['display_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Game</label>
                    <select name="game_id" class="form-select" required>
                        <option value="">-- Pilih Game --</option>
                        <?php while($game = $games->fetch_assoc()): ?>
                            <option value="<?= $game['id']; ?>"><?= htmlspecialchars($game['title']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hours Played</label>
                    <input type="number" name="hours_played" class="form-control" value="0" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date Added</label>
                    <input type="date" name="date_added" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Is Favorite?</label>
                    <select name="is_favorite" class="form-select">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Save</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>