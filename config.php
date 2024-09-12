<?php
$servername = "sql111.infinityfree.com";
$username = "if0_37204317";
$password = "AV9lc2hFdhXX";
$dbname = "if0_37204317_absensi_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
