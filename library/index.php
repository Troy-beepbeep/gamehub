<?php
$pageTitle = "Game Library";
require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

$query = "
SELECT 
    gl.id, 
    pp.display_name, 
    g.title, 
    gl.hours_played, 
    gl.date_added, 
    gl.is_favorite
FROM game_library gl
INNER JOIN player_profiles pp ON gl.player_profile_id = pp.id
INNER JOIN games g ON gl.game_id = g.id
ORDER BY gl.id DESC
";
$result = $conn->query($query);
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-collection"></i> Game Library</h2>
        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add to Library
        </a>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <?php if($_GET['success'] == "add"): ?>
            <div class="alert alert-success">Game berhasil ditambahkan ke Library 🎉</div>
        <?php endif; ?>
        <?php if($_GET['success'] == "edit"): ?>
            <div class="alert alert-warning">Library berhasil diupdate ✏️</div>
        <?php endif; ?>
        <?php if($_GET['success'] == "delete"): ?>
            <div class="alert alert-danger">Game berhasil dihapus dari Library 🗑️</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="70">ID</th>
                        <th>Player</th>
                        <th>Game</th>
                        <th>Hours Played</th>
                        <th>Date Added</th>
                        <th>Favorite?</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['display_name']); ?></td>
                                <td><?= htmlspecialchars($row['title']); ?></td>
                                <td><?= $row['hours_played']; ?> hrs</td>
                                <td><?= $row['date_added']; ?></td>
                                <td><?= $row['is_favorite'] ? '⭐ Yes' : 'No'; ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus dari library?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada game di library.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>