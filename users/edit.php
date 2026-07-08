<?php

$pageTitle = "Edit User";

require_once "../config/database.php";
require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

$id = (int)($_GET["id"] ?? 0);

$stmt = $conn->prepare("
SELECT *
FROM users
WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {

    die("User tidak ditemukan");

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);

    $stmt = $conn->prepare("
        UPDATE users
        SET username = ?, email = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssi",
        $username,
        $email,
        $id
    );

    $stmt->execute();

    header("Location: index.php?success=edit");

    exit;

}

?>

<div class="container-fluid">

<h2 class="mb-4">

Edit User

</h2>

<div class="card">

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label class="form-label">

Username

</label>

<input
type="text"
name="username"
class="form-control"
value="<?= htmlspecialchars($user['username']) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($user['email']) ?>"
required>

</div>

<button class="btn btn-warning">

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