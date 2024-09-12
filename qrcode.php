<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code untuk Absensi</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        .container {
            text-align: center;
        }
        img {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Scan QR Code untuk Absensi</h1>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=http://localhost/absensi/form.php?code=OSISTARUNABANGSAABSENSIFORMS2024" alt="QR Code">
    </div>
</body>
</html>
