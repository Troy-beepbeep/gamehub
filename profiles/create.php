<?php

$pageTitle = "Add Player Profile";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Ambil user yang belum punya profile
|--------------------------------------------------------------------------
*/

$userQuery = "
SELECT users.id, users.username
FROM users
LEFT JOIN player_profiles
ON users.id = player_profiles.user_id
WHERE player_profiles.user_id IS NULL
ORDER BY users.username ASC
";

$userResult = $conn->query($userQuery);

/*
|--------------------------------------------------------------------------
| Simpan Data
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['user_id'];
    $display_name = trim($_POST['display_name']);
    $avatar_url = trim($_POST['avatar_url']);
    $bio = trim($_POST['bio']);
    $favorite_genre = trim($_POST['favorite_genre']);
    $join_date = $_POST['join_date'];

    $stmt = $conn->prepare("
        INSERT INTO player_profiles
        (user_id, display_name, avatar_url, bio, favorite_genre, join_date)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isssss",
        $user_id,
        $display_name,
        $avatar_url,
        $bio,
        $favorite_genre,
        $join_date
    );

    $stmt->execute();

    header("Location: index.php?success=add");
    exit;
}

?>

<div class="container-fluid">

    <h2 class="mb-4">

        <i class="bi bi-person-plus-fill"></i>

        Add Player Profile

    </h2>

    <div class="card">

        <div class="card-body">

<?php if($userResult->num_rows == 0): ?>

<div class="alert alert-warning">

Semua user udah mempunyai profile.

</div>

<a href="index.php" class="btn btn-secondary">

Kembali

</a>

<?php else: ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

User

</label>

<select
name="user_id"
class="form-select"
required>

<option value="">

-- Pilih User --

</option>

<?php while($user = $userResult->fetch_assoc()): ?>

<option value="<?= $user['id']; ?>">

<?= htmlspecialchars($user['username']); ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Display Name

</label>

<input
type="text"
name="display_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Avatar URL

</label>

<input
type="text"
name="avatar_url"
class="form-control">

</div>

<div class="mb-3">

<label class="form-label">

Favorite Genre

</label>

<input
type="text"
name="favorite_genre"
class="form-control">

</div>

<div class="mb-3">

<label class="form-label">

Bio

</label>

<textarea
name="bio"
class="form-control"
rows="4"></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Join Date

</label>

<input
type="date"
name="join_date"
class="form-control">

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

<?php endif; ?>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>