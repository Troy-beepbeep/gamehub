<?php
$pageTitle = "Edit Library";
require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

$id = (int) ($_GET['id'] ?? 0);
$stmt = $conn->prepare("
    SELECT gl.*, pp.display_name, g.title 
    FROM game_library gl
    INNER JOIN player_profiles pp ON gl.player_profile_id = pp.id
    INNER JOIN games g ON gl.game_id = g.id
    WHERE gl.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit;
}
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hours_played = (int) $_POST['hours_played'];
    $date_added = $_POST['date_added'];
    $is_favorite = (int) $_POST['is_favorite'];

    $update = $conn->prepare("UPDATE game_library SET hours_played=?, date_added=?, is_favorite=? WHERE id=?");
    $update->bind_param("isii", $hours_played, $date_added, $is_favorite, $id);
    $update->execute();
    
    header("Location: index.php?success=edit");
    exit;
}
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="bi bi-pencil-square"></i> Edit Library Entry</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Player</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['display_name']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Game</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['title']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hours Played</label>
                    <input type="number" name="hours_played" class="form-control" value="<?= $data['hours_played']; ?>" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date Added</label>
                    <input type="date" name="date_added" class="form-control" value="<?= $data['date_added']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Is Favorite?</label>
                    <select name="is_favorite" class="form-select">
                        <option value="0" <?= $data['is_favorite'] == 0 ? 'selected' : ''; ?>>No</option>
                        <option value="1" <?= $data['is_favorite'] == 1 ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-circle"></i> Update</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>