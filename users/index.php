<?php

$pageTitle = "Users";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

$query = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($query);

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            <i class="bi bi-people-fill"></i>

            Users

        </h2>

        <a href="create.php" class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            Add User

        </a>

    </div>

    <div class="card">

        <div class="card-body">

        <?php if(isset($_GET['success'])): ?>

    <?php if($_GET['success'] == "add"): ?>

        <div class="alert alert-success">

            User berhasil ditambahkan 🎉

        </div>

    <?php endif; ?>

    <?php if($_GET['success'] == "edit"): ?>

        <div class="alert alert-warning">

            User berhasil diupdate ✏️

        </div>

    <?php endif; ?>

    <?php if($_GET['success'] == "delete"): ?>

        <div class="alert alert-danger">

            User berhasil dihapus 🗑️

        </div>

    <?php endif; ?>

<?php endif; ?>

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>

                        <th>Username</th>

                        <th>Email</th>

                        <th>Created At</th>

                        <th width="180">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php if($result->num_rows > 0): ?>

                    <?php while($row = $result->fetch_assoc()): ?>

                        <tr>

                            <td><?= $row['id']; ?></td>

                            <td><?= htmlspecialchars($row['username']); ?></td>

                            <td><?= htmlspecialchars($row['email']); ?></td>

                            <td><?= $row['created_at']; ?></td>

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
                                    onclick="return confirm('Delete this user?')">

                                    <i class="bi bi-trash"></i>

                                    Delete

                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5" class="text-center">

                            No users found

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