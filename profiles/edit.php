<?php

$pageTitle = "Edit Player Profile";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare("
SELECT player_profiles.*, users.username
FROM player_profiles
INNER JOIN users
ON player_profiles.user_id = users.id
WHERE player_profiles.id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: index.php");
    exit;

}

$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $display_name = trim($_POST['display_name']);
    $avatar_url = trim($_POST['avatar_url']);
    $bio = trim($_POST['bio']);
    $favorite_genre = trim($_POST['favorite_genre']);
    $join_date = $_POST['join_date'];

    $stmt = $conn->prepare("
    UPDATE player_profiles
    SET
        display_name=?,
        avatar_url=?,
        bio=?,
        favorite_genre=?,
        join_date=?
    WHERE id=?
    ");

    $stmt->bind_param(
        "sssssi",
        $display_name,
        $avatar_url,
        $bio,
        $favorite_genre,
        $join_date,
        $id
    );

    $stmt->execute();

    header("Location: index.php?success=edit");
    exit;

}

?>

<div class="container-fluid">

<h2 class="mb-4">

Edit Player Profile

</h2>

<div class="card">

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>User</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($data['username']); ?>"
readonly>

</div>

<div class="mb-3">

<label>Display Name</label>

<input
type="text"
name="display_name"
class="form-control"
value="<?= htmlspecialchars($data['display_name']); ?>"
required>

</div>

<div class="mb-3">

<label>Avatar URL</label>

<input
type="text"
name="avatar_url"
class="form-control"
value="<?= htmlspecialchars($data['avatar_url']); ?>">

</div>

<div class="mb-3">

<label>Favorite Genre</label>

<select
name="favorite_genre"
class="form-select">

<?php

$genres = [
"Action",
"Adventure",
"RPG",
"FPS",
"MOBA",
"Simulation",
"Sports",
"Racing",
"Strategy"
];

foreach($genres as $genre){

$selected = ($genre == $data['favorite_genre']) ? "selected" : "";

echo "<option $selected>$genre</option>";

}

?>

</select>

</div>

<div class="mb-3">

<label>Bio</label>

<textarea
name="bio"
class="form-control"
rows="4"><?= htmlspecialchars($data['bio']); ?></textarea>

</div>

<div class="mb-3">

<label>Join Date</label>

<input
type="date"
name="join_date"
class="form-control"
value="<?= $data['join_date']; ?>">

</div>

<button
class="btn btn-warning"
type="submit">

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

<?php require_once "../includes/footer.php"; ?>