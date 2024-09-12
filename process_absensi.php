<?php
include 'config.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Validasi dan ambil data dari form
$jabatan_osis = $_POST['jabatan_osis'];
$location = $_POST['location'];

if (isset($_FILES['foto_selfie']) && $_FILES['foto_selfie']['error'] == UPLOAD_ERR_OK) {
    $foto_selfie = $_FILES['foto_selfie'];
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($foto_selfie['name']);
    
    if (move_uploaded_file($foto_selfie['tmp_name'], $uploadFile)) {
        $sql = "INSERT INTO absensi (siswa_id, jabatan_osis, foto_selfie, waktu_absen, location) VALUES (?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $_SESSION['siswa_id'], $jabatan_osis, $foto_selfie['name'], $location);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Upload error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
}

