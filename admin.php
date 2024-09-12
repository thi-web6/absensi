<?php
session_start();
include 'config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Mengambil data absensi dari database
$sql = "SELECT a.id, s.nama, a.jabatan_osis, a.foto_selfie, a.waktu_absen, a.location 
        FROM absensi a 
        JOIN siswa s ON a.siswa_id = s.id 
        ORDER BY a.waktu_absen DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Absensi</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }

        .header {
            background: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .header .date-time {
            font-size: 18px;
            margin-top: 10px;
        }

        .container {
            padding: 20px;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .btn-refresh {
            background: #6e8efb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .btn-refresh:hover {
            background: #5a79da;
        }

        .foto-selfie {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
            object-fit: cover;
        }
    </style>
    <script>
        function updateDateTime() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta' };
            document.getElementById('currentDateTime').innerText = now.toLocaleString('id-ID', options);
        }

        window.onload = updateDateTime;
    </script>
</head>
<body>
    <div class="header">
        <h1>Data Absensi</h1>
        <div class="date-time" id="currentDateTime"></div>
        <a href="admin.php" class="btn-refresh">Refresh Data</a>
    </div>

    <div class="container">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>Jabatan OSIS</th>
                        <th>Foto Selfie</th>
                        <th>Waktu Absen</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['jabatan_osis']); ?></td>
                                <td><img src="uploads/<?php echo htmlspecialchars($row['foto_selfie']); ?>" alt="Foto Selfie" class="foto-selfie"></td>
                                <td><?php echo htmlspecialchars($row['waktu_absen']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Tidak ada data absensi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
