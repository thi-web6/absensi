<?php
// Cek apakah formulir telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simpan status ke file konfigurasi
    $status = isset($_POST['status']) ? 'enabled' : 'disabled';
    file_put_contents('status.txt', $status);
}

// Baca status dari file konfigurasi
$status = file_exists('status.txt') ? trim(file_get_contents('status.txt')) : 'disabled';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Pembatasan Waktu</title>
</head>
<body>
    <h1>Pengaturan Pembatasan Waktu</h1>
    <form method="post">
        <label>
            <input type="checkbox" name="status" <?php echo $status == 'enabled' ? 'checked' : ''; ?>>
            Aktifkan Pembatasan Waktu
        </label>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
