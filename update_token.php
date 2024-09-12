<?php
include 'config.php';

// Ambil waktu server saat ini
$current_time = new DateTime();
$current_hour = $current_time->format('H');

// Jika waktu server sudah lewat jam 6 pagi
if ($current_hour >= 6) {
    // Generate token baru
    $new_token = bin2hex(random_bytes(16));

    // Hapus token lama
    $sql = "DELETE FROM qr_code";
    $conn->query($sql);

    // Insert token baru
    $sql = "INSERT INTO qr_code (token) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $new_token);
    
    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Terjadi kesalahan saat mengupdate token: " . $stmt->error;
    }
} else {
    echo "";
}
?>