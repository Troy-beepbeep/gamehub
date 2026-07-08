<?php

require_once "../config/database.php";

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {

    header("Location: index.php");
    exit;

}

$stmt = $conn->prepare("
SELECT id
FROM player_profiles
WHERE id=?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: index.php");
    exit;

}

$stmt = $conn->prepare("
DELETE FROM player_profiles
WHERE id=?
");

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: index.php?success=delete");

exit;