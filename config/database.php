<?php

// =====================================
// GameHub Database Configuration
// =====================================

// Aktifkan laporan error MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Konfigurasi database
$host     = "localhost";
$username = "root";
$password = "";
$database = "gamehub";

try {

    // Membuat koneksi
    $conn = new mysqli($host, $username, $password, $database);

    // Gunakan UTF-8
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {

    die("Database connection failed: " . $e->getMessage());

}