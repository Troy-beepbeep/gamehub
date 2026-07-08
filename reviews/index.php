<?php

$pageTitle = "Reviews";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Ambil Semua Review
|--------------------------------------------------------------------------
*/

$query = "
SELECT
    reviews.id,
    games.title,
    player_profiles.display_name,
    reviews.rating,
    reviews.comment,
    reviews.review_date
FROM reviews
INNER JOIN games
    ON reviews.game_id = games.id
INNER JOIN player_profiles
    ON reviews.player_profile_id = player_profiles.id
ORDER BY reviews.id DESC
";

$result = $conn->query($query);

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            <i class="bi bi-star-fill"></i>

            Reviews

        </h2>

        <a href="create.php" class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            Add Review

        </a>

    </div>

    <?php if(isset($_GET['success'])): ?>

        <?php if($_GET['success']=="add"): ?>

            <div class="alert alert-success">

                Review berhasil ditambahkan 🎉

            </div>

        <?php endif; ?>

        <?php if($_GET['success']=="edit"): ?>

            <div class="alert alert-warning">

                Review berhasil diupdate ✏️

            </div>

        <?php endif; ?>

        <?php if($_GET['success']=="delete"): ?>

            <div class="alert alert-danger">

                Review berhasil dihapus 🗑️

            </div>

        <?php endif; ?>

    <?php endif; ?>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="70">ID</th>
                        <th>Game</th>
                        <th>Player</th>
                        <th width="100">Rating</th>
                        <th>Comment</th>
                        <th width="120">Review Date</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php if($result->num_rows > 0): ?>

                    <?php while($row = $result->fetch_assoc()): ?>

                        <tr>

                            <td><?= $row['id']; ?></td>

                            <td><?= htmlspecialchars($row['title']); ?></td>

                            <td><?= htmlspecialchars($row['display_name']); ?></td>

                            <td><?= $row['rating']; ?>/5</td>

                            <td><?= htmlspecialchars($row['comment']); ?></td>

                            <td><?= $row['review_date']; ?></td>

                            <td>

                                <a
                                    href="edit.php?id=<?= $row['id']; ?>"
                                    class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                    Edit

                                </a>

                                <a
                                    href="delete.php?id=<?= $row['id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin mau menghapus review ini?')">

                                    <i class="bi bi-trash"></i>

                                    Delete

                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="7" class="text-center">

                            Belum ada data review.

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>