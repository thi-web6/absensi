<?php
include 'config.php';

// Menghasilkan token unik
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

// Hapus token yang lebih dari 24 jam
$sql = "DELETE FROM qr_code WHERE generated_at < NOW() - INTERVAL 1 DAY";
$conn->query($sql);

// Hapus token yang ada jika sudah ada
$sql = "DELETE FROM qr_code WHERE code = 'OSISSMKTARUNABANGSAABSENSI2024'";
$conn->query($sql);

// Generate token baru
$newToken = generateToken();

// Insert token ke database
$sql = "INSERT INTO qr_code (code, token) VALUES ('OSISSMKTARUNABANGSAABSENSI2024', ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $newToken);

if ($stmt->execute()) {
    echo "QR Code token telah diperbarui.";
} else {
    echo "Gagal memperbarui token QR Code: " . $stmt->error;
}
?>
