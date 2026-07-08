<?php

$pageTitle = "Edit Review";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Ambil ID Review
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare("
    SELECT *
    FROM reviews
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: index.php");
    exit;

}

$review = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| Ambil Data Games
|--------------------------------------------------------------------------
*/

$games = $conn->query("
    SELECT id, title
    FROM games
    ORDER BY title ASC
");

/*
|--------------------------------------------------------------------------
| Ambil Data Player
|--------------------------------------------------------------------------
*/

$players = $conn->query("
    SELECT id, display_name
    FROM player_profiles
    ORDER BY display_name ASC
");

/*
|--------------------------------------------------------------------------
| Update Review
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $game_id = (int) $_POST['game_id'];
    $player_profile_id = (int) $_POST['player_profile_id'];
    $rating = (int) $_POST['rating'];
    $comment = trim($_POST['comment']);
    $review_date = $_POST['review_date'];

    $stmt = $conn->prepare("
        UPDATE reviews
        SET
            game_id = ?,
            player_profile_id = ?,
            rating = ?,
            comment = ?,
            review_date = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "iiissi",
        $game_id,
        $player_profile_id,
        $rating,
        $comment,
        $review_date,
        $id
    );

    $stmt->execute();

    header("Location: index.php?success=edit");
    exit;

}

?>

<div class="container-fluid">

    <h2 class="mb-4">

        <i class="bi bi-pencil-square"></i>

        Edit Review

    </h2>

    <div class="card shadow-sm">

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Game

                    </label>

                    <select
                        name="game_id"
                        class="form-select"
                        required>

                        <?php while($game = $games->fetch_assoc()): ?>

                            <option
                                value="<?= $game['id']; ?>"
                                <?= ($game['id'] == $review['game_id']) ? 'selected' : ''; ?>>

                                <?= htmlspecialchars($game['title']); ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Player

                    </label>

                    <select
                        name="player_profile_id"
                        class="form-select"
                        required>

                        <?php while($player = $players->fetch_assoc()): ?>

                            <option
                                value="<?= $player['id']; ?>"
                                <?= ($player['id'] == $review['player_profile_id']) ? 'selected' : ''; ?>>

                                <?= htmlspecialchars($player['display_name']); ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Rating

                    </label>

                    <select
                        name="rating"
                        class="form-select"
                        required>

                        <?php for($i = 1; $i <= 5; $i++): ?>

                            <option
                                value="<?= $i; ?>"
                                <?= ($i == $review['rating']) ? 'selected' : ''; ?>>

                                <?= $i; ?> ⭐

                            </option>

                        <?php endfor; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Comment

                    </label>

                    <textarea
                        name="comment"
                        class="form-control"
                        rows="4"><?= htmlspecialchars($review['comment']); ?></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Review Date

                    </label>

                    <input
                        type="date"
                        name="review_date"
                        class="form-control"
                        value="<?= $review['review_date']; ?>"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-warning">

                    <i class="bi bi-check-circle"></i>

                    Update

                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>