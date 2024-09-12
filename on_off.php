<?php
session_start();
include 'config.php'; // Include file konfigurasi jika ada

// Handle button click
if (isset($_POST['status'])) {
    $status = $_POST['status'];
    $statusFile = 'absensi%20forms/status.txt';

    // Validasi input dan update status
    if ($status === 'on') {
        file_put_contents($statusFile, 'enabled');
        $message = "Absensi diaktifkan.";
    } elseif ($status === 'off') {
        file_put_contents($statusFile, 'disabled');
        $message = "Absensi dinonaktifkan.";
    } else {
        $message = "Status tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontrol Akses Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            color: white;
            background: #6e8efb;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #5a79da;
        }
        .message {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kontrol Akses Absensi</h1>
        <form action="on_off.php" method="POST">
            <button type="submit" name="status" value="on">Aktifkan Absensi</button>
            <button type="submit" name="status" value="off">Nonaktifkan Absensi</button>
        </form>
        <?php if (isset($message)) : ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
