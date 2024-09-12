<?php
include 'config.php';

// Update token jika sudah lewat jam 6 pagi
include 'update_token.php';

// Ambil token terbaru dari database
$sql = "SELECT token FROM qr_code ORDER BY generated_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $token = $row['token'];
} else {
    $token = 'default_token'; // Token default jika tidak ada token di database
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code & Jadwal Piket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            overflow-y: auto;
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding: 10px 20px;
            box-sizing: border-box;
        }

        .refresh-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .refresh-button:hover {
            background-color: #0056b3;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
            box-sizing: border-box;
        }

        .button-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .absensi-button {
            background-color: #28a745;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .absensi-button:hover {
            background-color: #218838;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: left;
        }

        table.jadwal-piket {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: auto;
        }

        table.jadwal-piket th, table.jadwal-piket td {
            border: 3px solid #007bff; /* Tebalkan garis tabel */
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        table.jadwal-piket th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .catatan {
            text-align: left;
            margin-top: 20px;
            font-size: 14px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            max-width: 800px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="refresh-button" title="Refresh">Refresh</a>
    </div>

    <div class="container">
        <div class="button-section">
            <h1>Absensi Online</h1>
            <a href="absensi.php?code=<?php echo htmlspecialchars($token); ?>" class="absensi-button">Klik untuk Absensi</a>
        </div>

        <h1>Jadwal Piket</h1>
        <table class="jadwal-piket">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
               <!-- SENIN -->
                <tr>
                    <td rowspan="14" style="vertical-align: middle;">SENIN</td>
                    <td><b>Tifany Charissa</b></td>
                </tr>
                <tr><td><b>Falisha Sharlieslz Ra</b></td></tr>
                <tr><td><b>Nidaan Khofiyal K.</b></td></tr>
                <tr><td><b>Syendi Cahyani sarif</b></td></tr>
                <tr><td><b>Reihan Dwi Saputra</b></td></tr>
                <tr><td><b>Nur Arif Ardiansyah</b></td></tr>
                <tr><td><b>Khalid Luhur Pambudi</b></td></tr>
                <tr><td><b>Muhammad Rasyid</b></td></tr>
                <tr><td><b>Muhammad Alif Rizky</b></td></tr>
                <tr><td><b>Putra Muhammad Rizky</b></td></tr>
                <tr><td><b>Asyam Maulana Thahrir</b></td></tr>
                <tr><td><b>Raditya Alfarizi Nugraha</b></td></tr>
                <tr><td><b>Hazman Malik Shafara</b></td></tr>
                <tr><td><b>Alfawaz Khairi Kasyaif</b></td></tr>

                <!-- SELASA -->
                <tr>
                    <td rowspan="13" style="vertical-align: middle;">SELASA</td>
                    <td><b>Tian Adriana Putri</b></td>
                </tr>
                <tr><td><b>Zeta Maylafayya Arhan Nursyifa</b></td></tr>
                <tr><td><b>Meylani Aulia Putri Aninda</b></td></tr>
                <tr><td><b>Anggun Lestari</b></td></tr>
                <tr><td><b>Pangestu Syachri Ramadhan</b></td></tr>
                <tr><td><b>Muhammad Fathi Al-Naqi</b></td></tr>
                <tr><td><b>Abdurrohman Al Fathi</b></td></tr>
                <tr><td><b>Muhammad Fakhri Abiyyu</b></td></tr>
                <tr><td><b>Rafael Matthew Tiban Herin</b></td></tr>
                <tr><td><b>Bagus Nashr Kausar</b></td></tr>
                <tr><td><b>Hafizh Raesha Putra</b></td></tr>
                <tr><td><b>Abdad Rafa Tefino</b></td></tr>
                <tr><td><b>Ardian Ramadhani</b></td></tr>

                <!-- RABU -->
                <tr>
                    <td rowspan="13" style="vertical-align: middle;">RABU</td>
                    <td><b>Rena Ramadani</b></td>
                </tr>
                <tr><td><b>Adzkia Syifa</b></td></tr>
                <tr><td><b>Mutiara Aprilya</b></td></tr>
                <tr><td><b>Allmira Hilda Yanti</b></td></tr>
                <tr><td><b>Muhammad Ja'far Shiddiq</b></td></tr>
                <tr><td><b>Ijlal Rifan Priandi</b></td></tr>
                <tr><td><b>Ramadhan Aunur Rahman</b></td></tr>
                <tr><td><b>Mohammad Alf Akbar</b></td></tr>
                <tr><td><b>Agung Widya Navanto</b></td></tr>
                <tr><td><b>Fakhri Putra Prasasti</b></td></tr>
                <tr><td><b>Muhammad Faizal</b></td></tr>
                <tr><td><b>Muhammad Rafi Ayman Zafir</b></td></tr>
                <tr><td><b>Franssiskus Adverndra Lagatawi Lewokeda</b></td></tr>

                <!-- KAMIS -->
                <tr>
                    <td rowspan="13" style="vertical-align: middle;">KAMIS</td>
                    <td><b>Wulan Fitria Zahra</b></td>
                </tr>
                <tr><td><b>Bianca Kesya Maharani</b></td></tr>
                <tr><td><b>Adinda Cahaya Utami</b></td></tr>
                <tr><td><b>Zazkya Putri Batubara</b></td></tr>
                <tr><td><b>Thoriq Balfas</b></td></tr>
                <tr><td><b>Widhy Nur Al-Lail</b></td></tr>
                <tr><td><b>Muhammad Alviansyah</b></td></tr>
                <tr><td><b>Muhammad Raffa Alfarizi</b></td></tr>
                <tr><td><b>Mirza Azwan Waranggani</b></td></tr>
                <tr><td><b>Mohammad Varvan Denart</b></td></tr>
                <tr><td><b>Rizqulloh Akmal Putra</b></td></tr>
                <tr><td><b>Aldi Marliyano Saputra</b></td></tr>
                <tr><td><b>Muhammad Faris Azimiarif</b></td></tr>

                <!-- JUM'AT -->
                <tr>
                    <td rowspan="14" style="vertical-align: middle;">JUM'AT</td>
                    <td><b>Allysa Abdurrahman</b></td>
                </tr>
                <tr><td><b>Andita Tifani</b></td></tr>
                <tr><td><b>Kinanti Anggraeni</b></td></tr>
                <tr><td><b>Wa Ode Zaskia Aulia Ghowe</b></td></tr>
                <tr><td><b>Kusye Vanessa Putri Cun</b></td></tr>
                <tr><td><b>Chescka Yafi Ayyuasy</b></td></tr>
                <tr><td><b>Muhammad Viko Adriansyah</b></td></tr>
                <tr><td><b>Zivalka Putra Raharjo</b></td></tr>
                <tr><td><b>Afdlalur Rahman Robbanii</b></td></tr>
                <tr><td><b>Adriyan Nail</b></td></tr>
                <tr><td><b>Muhammad Gavra Wijaya</b></td></tr>
                <tr><td><b>Rasya Arista Putra</b></td></tr>
                <tr><td><b>Muhammad Hamdhan Ardiansyah</b></td></tr>
                <tr><td><b>Adam Purwo Pratama</b></td></tr>
            </tbody>
        </table>

        
        <div class="catatan">
            <p><b>CATATAN:</b></p>
            <p>DENDA TELAT = 5.000</p>
            <p>DENDA TIDAK BERJAGA = 10.000</p>
            <p>#JIKA SAKIT WAJIB IZIN KE PEMBINA</p>
            <p><b>SINGKATAN:</b></p>
            <p>Sakit (S)</p>
            <p>Izin (I)</p>
            <p>Telat (T)</p>
            <p>Tidak berjaga padahal masuk sekolah (TB)</p>
            <p>Masuk (P)</p>
            <p>Libur</p>
        </div>
    </div></body>
</html>
