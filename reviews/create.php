<?php

$pageTitle = "Add Review";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

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
| Ambil Data Player Profiles
|--------------------------------------------------------------------------
*/

$players = $conn->query("
    SELECT id, display_name
    FROM player_profiles
    ORDER BY display_name ASC
");

/*
|--------------------------------------------------------------------------
| Simpan Review
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $game_id = (int) $_POST['game_id'];
    $player_profile_id = (int) $_POST['player_profile_id'];
    $rating = (int) $_POST['rating'];
    $comment = trim($_POST['comment']);
    $review_date = $_POST['review_date'];

    $stmt = $conn->prepare("
        INSERT INTO reviews
        (game_id, player_profile_id, rating, comment, review_date)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iiiss",
        $game_id,
        $player_profile_id,
        $rating,
        $comment,
        $review_date
    );

    $stmt->execute();

    header("Location: index.php?success=add");
    exit;

}

?>

<div class="container-fluid">

    <h2 class="mb-4">

        <i class="bi bi-star-fill"></i>

        Add Review

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

                        <option value="">-- Pilih Game --</option>

                        <?php while($game = $games->fetch_assoc()): ?>

                            <option value="<?= $game['id']; ?>">

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

                        <option value="">-- Pilih Player --</option>

                        <?php while($player = $players->fetch_assoc()): ?>

                            <option value="<?= $player['id']; ?>">

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

                        <option value="1">1 ⭐</option>
                        <option value="2">2 ⭐</option>
                        <option value="3">3 ⭐</option>
                        <option value="4">4 ⭐</option>
                        <option value="5">5 ⭐</option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Comment

                    </label>

                    <textarea
                        name="comment"
                        class="form-control"
                        rows="4"></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Review Date

                    </label>

                    <input
                        type="date"
                        name="review_date"
                        class="form-control"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-floppy"></i>

                    Save

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