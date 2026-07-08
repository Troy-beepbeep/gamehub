<?php

$pageTitle = "Games";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Ambil Semua Data Game
|--------------------------------------------------------------------------
*/

$query = "
SELECT *
FROM games
ORDER BY id DESC
";

$result = $conn->query($query);

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-controller"></i>
            Games
        </h2>

        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Add Game
        </a>

    </div>

    <?php if(isset($_GET['success'])): ?>

        <?php if($_GET['success'] == "add"): ?>

            <div class="alert alert-success">
                Game berhasil ditambahkan 🎉
            </div>

        <?php endif; ?>

        <?php if($_GET['success'] == "edit"): ?>

            <div class="alert alert-warning">
                Game berhasil diupdate ✏️
            </div>

        <?php endif; ?>

        <?php if($_GET['success'] == "delete"): ?>

            <div class="alert alert-danger">
                Game berhasil dihapus 🗑️
            </div>

        <?php endif; ?>

    <?php endif; ?>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="70">ID</th>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Publisher</th>
                        <th width="120">Release Year</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php if($result->num_rows > 0): ?>

                    <?php while($row = $result->fetch_assoc()): ?>

                        <tr>

                            <td><?= $row['id']; ?></td>

                            <td><?= htmlspecialchars($row['title']); ?></td>

                            <td><?= htmlspecialchars($row['genre']); ?></td>

                            <td><?= htmlspecialchars($row['publisher']); ?></td>

                            <td><?= $row['release_year']; ?></td>

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
                                    onclick="return confirm('Yakin mau menghapus game ini?')">

                                    <i class="bi bi-trash"></i>
                                    Delete

                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="6" class="text-center">

                            Belum ada data game.

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