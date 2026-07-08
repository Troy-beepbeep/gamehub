<?php

$pageTitle = "Add Game";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Simpan Data
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $publisher = trim($_POST['publisher']);
    $release_year = $_POST['release_year'];

    $stmt = $conn->prepare("
        INSERT INTO games
        (title, genre, publisher, release_year)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssss",
        $title,
        $genre,
        $publisher,
        $release_year
    );

    $stmt->execute();

    header("Location: index.php?success=add");
    exit;
}

?>

<div class="container-fluid">

    <h2 class="mb-4">

        <i class="bi bi-plus-circle-fill"></i>

        Add Game

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

                        <option value="">-- Pilih Genre --</option>

                        <option>Action</option>
                        <option>Adventure</option>
                        <option>FPS</option>
                        <option>MOBA</option>
                        <option>RPG</option>
                        <option>Sandbox</option>
                        <option>Simulation</option>
                        <option>Sports</option>
                        <option>Strategy</option>
                        <option>Racing</option>

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