<?php

$pageTitle = "Edit Game";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Ambil ID
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare("
    SELECT *
    FROM games
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: index.php");
    exit;

}

$game = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| Update Data
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $publisher = trim($_POST['publisher']);
    $release_year = $_POST['release_year'];

    $stmt = $conn->prepare("
        UPDATE games
        SET
            title = ?,
            genre = ?,
            publisher = ?,
            release_year = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssssi",
        $title,
        $genre,
        $publisher,
        $release_year,
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

        Edit Game

    </h2>

    <div class="card shadow-sm">

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Game Title

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="<?= htmlspecialchars($game['title']); ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Genre

                    </label>

                    <select
                        name="genre"
                        class="form-select"
                        required>

                        <?php

                        $genres = [
                            "Action",
                            "Adventure",
                            "FPS",
                            "MOBA",
                            "RPG",
                            "Sandbox",
                            "Simulation",
                            "Sports",
                            "Strategy",
                            "Racing"
                        ];

                        foreach ($genres as $genre) {

                            $selected = ($genre == $game['genre']) ? "selected" : "";

                            echo "<option value=\"$genre\" $selected>$genre</option>";

                        }

                        ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Publisher

                    </label>

                    <input
                        type="text"
                        name="publisher"
                        class="form-control"
                        value="<?= htmlspecialchars($game['publisher']); ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Release Year

                    </label>

                    <input
                        type="number"
                        name="release_year"
                        class="form-control"
                        min="1980"
                        max="2100"
                        value="<?= $game['release_year']; ?>"
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