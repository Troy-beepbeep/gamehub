<?php

$pageTitle = "Player Profiles";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

$query = "
SELECT
    player_profiles.*,
    users.username
FROM player_profiles
INNER JOIN users
ON player_profiles.user_id = users.id
ORDER BY player_profiles.id DESC
";

$result = $conn->query($query);

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            <i class="bi bi-person-badge-fill"></i>

            Player Profiles

        </h2>

        <a href="create.php" class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            Add Profile

        </a>

    </div>

    <div class="card">

        <div class="card-body">

        <?php if(isset($_GET['success'])): ?>

<div class="alert alert-success">

Player Profile berhasil ditambahkan 🎉

</div>

<?php endif; ?>

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Username</th>
                        <th>Display Name</th>
                        <th>Favorite Genre</th>
                        <th>Join Date</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php while($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?= $row['id']; ?></td>

                        <td><?= htmlspecialchars($row['username']); ?></td>

                        <td><?= htmlspecialchars($row['display_name']); ?></td>

                        <td><?= htmlspecialchars($row['favorite_genre']); ?></td>

                        <td><?= $row['join_date']; ?></td>

                        <td>

                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">

                                Delete

                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>