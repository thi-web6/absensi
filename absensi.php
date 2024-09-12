<?php
// Sertakan file pengecekan akses
include 'check_access.php'; // Pastikan absensi.php diatur dengan on_off.php

session_start();
include 'config.php';

// Verifikasi QR Code
if (!isset($_GET['code'])) {
    die("Kode QR tidak valid.");
}

$code = $_GET['code'];

// Verifikasi token di database
$sql = "SELECT token FROM qr_code WHERE token = ? ORDER BY generated_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
            alert('Kode QR tidak valid. Pastikan kode QR yang Anda gunakan benar.');
            window.location.href = 'index.php'; // Redirect ke halaman utama
          </script>";
    exit();
}

// Menyimpan data absensi
if (isset($_POST['submit'])) {
    $siswa_id = $_POST['siswa'];
    $jabatan_osis = $_POST['jabatan_osis'];
    $foto_selfie = $_FILES['foto_selfie']['tmp_name'];
    $foto_name = $_FILES['foto_selfie']['name'];
    $upload_dir = 'uploads/';
    $foto_path = $upload_dir . basename($foto_name);
    $submit_time = $_POST['submit_time'];
    $location = $_POST['location'];

    // Buat direktori uploads jika belum ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Cek ukuran file (maksimal 30MB)
    if ($_FILES['foto_selfie']['size'] > 30000000) { // Maksimal ukuran file adalah 30MB
        echo "<script>alert('File terlalu besar. Maksimal ukuran file adalah 30MB.');</script>";
        exit();
    }

    // Pindahkan file yang diupload ke direktori uploads
    if (move_uploaded_file($foto_selfie, $foto_path)) {
        // Siapkan query untuk menyimpan data ke database
        $sql = "INSERT INTO absensi (siswa_id, jabatan_osis, foto_selfie, waktu_absen, location) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $siswa_id, $jabatan_osis, $foto_name, $submit_time, $location);

        // Eksekusi query
        if ($stmt->execute()) {
            // Redirect ke success.html setelah sukses
            echo "<script>
                    window.location.href = 'success.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Terjadi kesalahan saat menyimpan data absensi: " . $stmt->error . "');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Gagal mengupload foto selfie.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi</title>
    <style>
        /* CSS Style */
body {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #6e8efb, #a777e3);
    font-family: 'Poppins', sans-serif;
}

.form-container {
    background: white;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.form-container h1 {
    margin-bottom: 30px;
    color: #333;
    font-size: 28px;
    font-weight: 600;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
    text-align: left;
}

select,
input[type="file"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 2px solid #6e8efb; /* Warna border yang konsisten dengan tombol */
    border-radius: 8px;
    background: #f7f7f7;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
    box-sizing: border-box; /* Pastikan padding tidak menambah lebar */
}

select:focus,
input[type="file"]:focus {
    border-color: #5a79da; /* Warna border saat fokus */
    background: #e7e7e7;
}

button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #6e8efb;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
    margin-bottom: 10px;
}

button:hover {
    background: #5a79da;
}

.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

.button-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Form Absensi</h1>
        <form id="absensiForm" action="absensi.php?code=<?php echo urlencode($code); ?>" method="POST" enctype="multipart/form-data">
            <label for="siswa">Nama Siswa:</label>
            <select name="siswa" id="siswa" required>
                <?php
                // Menampilkan daftar siswa dari database
                $result = $conn->query("SELECT id, nama, kelas FROM siswa");
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['nama']} - {$row['kelas']}</option>";
                    }
                } else {
                    echo "<option value=''>Gagal memuat data siswa.</option>";
                }
                ?>
            </select>

            <label for="jabatan_osis">Jabatan OSIS:</label>
            <select name="jabatan_osis" id="jabatan_osis" required>
                <!-- List of OSIS positions -->
                <?php
                $positions = [
                    "ketua osis", "wakil ketua osis 1", "wakil ketua osis 2",
                    "sekretaris 1", "sekretaris 2", "anggota sekretaris",
                    "bendahara 1", "bendahara 2", "anggota bendahara",
                    "ketua sekbid 1", "ketua sekbid 2", "ketua sekbid 3",
                    "ketua sekbid 4", "ketua sekbid 5", "wakil ketua sekbid 1",
                    "wakil ketua sekbid 2", "wakil ketua sekbid 3", "wakil ketua sekbid 4",
                    "wakil ketua sekbid 5", "anggota sekbid 1", "anggota sekbid 2",
                    "anggota sekbid 3", "anggota sekbid 4", "anggota sekbid 5"
                ];
                foreach ($positions as $position) {
                    echo "<option value='{$position}'>{$position}</option>";
                }
                ?>
            </select>

            <label for="foto_selfie">Foto Selfie:</label>
            <input type="file" name="foto_selfie" id="foto_selfie" accept="image/*" capture="camera" required>

            <input type="hidden" id="submit_time" name="submit_time">
            <input type="hidden" id="location" name="location">

            <div class="button-container">
                <button type="button" onclick="getLocation()">Ambil Lokasi</button>
                <button type="submit" name="submit">Kirim Absensi</button>
            </div>
            
            <div id="error-message" class="error-message"></div>
        </form>
    </div>

    <script>
        function setSubmitTime() {
            var submitTime = new Date();
            var hours = submitTime.getHours().toString().padStart(2, '0');
            var minutes = submitTime.getMinutes().toString().padStart(2, '0');
            var seconds = submitTime.getSeconds().toString().padStart(2, '0');
            var formattedTime = submitTime.getFullYear() + '-' +
                                (submitTime.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                submitTime.getDate().toString().padStart(2, '0') + ' ' +
                                hours + ':' + minutes + ':' + seconds;
            document.getElementById('submit_time').value = formattedTime;
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                document.getElementById('error-message').textContent = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById('location').value = latitude + ',' + longitude;
            document.getElementById('error-message').textContent = ""; // Clear any existing error message
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    document.getElementById('error-message').textContent = "User denied the request for Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    document.getElementById('error-message').textContent = "Location information is unavailable.";
                    break;
                case error.TIMEOUT:
                    document.getElementById('error-message').textContent = "The request to get user location timed out.";
                    break;
                case error.UNKNOWN_ERROR:
                    document.getElementById('error-message').textContent = "An unknown error occurred.";
                    break;
            }
        }

        function validateForm() {
            var location = document.getElementById('location').value;
            if (location === "") {
                document.getElementById('error-message').textContent = "Harap ambil lokasi terlebih dahulu.";
                return false; // Prevent form submission
            }
            setSubmitTime(); // Set the submit time
            return true; // Allow form submission
        }

        document.getElementById('absensiForm').addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    </script>
</body>
</html>
