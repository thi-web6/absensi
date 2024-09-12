<?php
session_start();
include 'config.php'; // Include your database configuration

// Set the timezone
date_default_timezone_set('Asia/Jakarta');

// Set the time range for late submissions (between 6:00 AM and 6:30 AM)
$startTime = date('Y-m-d 06:00:00');
$endTime = date('Y-m-d 06:30:00');

// Debug: Print the time range
echo "<p>Start Time: $startTime</p>";
echo "<p>End Time: $endTime</p>";

// Query to fetch late submissions
$sql = "SELECT siswa.nama, absensi.waktu_absen
        FROM absensi
        JOIN siswa ON absensi.siswa_id = siswa.id
        WHERE absensi.waktu_absen BETWEEN '$startTime' AND '$endTime'";

$result = $conn->query($sql);

if (!$result) {
    die("Failed to retrieve attendance data: " . $conn->error);
}

// Debug: Check number of rows returned
echo "<p>Number of rows returned: " . $result->num_rows . "</p>";

// Check if there are any late submissions
if ($result->num_rows > 0) {
    echo "<h2>Late Submissions</h2>";
    while ($row = $result->fetch_assoc()) {
        // Create the WhatsApp message content
        $message = urlencode("Nama: {$row['nama']} terlambat absen pada: {$row['waktu_absen']}");

        // WhatsApp link (updated to the new admin number)
        $whatsappLink = "https://api.whatsapp.com/send?phone=6285776671279&text=$message";

        echo "<p>Late Submission: {$row['nama']} - {$row['waktu_absen']}</p>";
        echo "<a href='$whatsappLink' target='_blank'>Kirim WhatsApp Notification</a><br>";
    }
} else {
    echo "No late submissions between 6:00 and 6:30 AM today.";
}
?>
