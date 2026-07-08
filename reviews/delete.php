<?php

require_once "../config/database.php";

/*
|--------------------------------------------------------------------------
| Ambil ID
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {

    header("Location: index.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Cek Data Review
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT id
    FROM reviews
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: index.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Hapus Data
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    DELETE
    FROM reviews
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: index.php?success=delete");
exit;

?>