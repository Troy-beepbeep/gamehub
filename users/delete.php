<?php

require_once "../config/database.php";

// Ambil ID dari URL
$id = (int)($_GET['id'] ?? 0);

// Validasi ID
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Cek apakah user ada
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT id
    FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    header("Location: index.php?error=notfound");
    exit;

}

/*
|--------------------------------------------------------------------------
| Hapus user
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    DELETE FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: index.php?success=delete");
exit;