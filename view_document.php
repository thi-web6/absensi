<?php
$file = $_GET['file'] ?? '';

if ($file) {
    $file_path = '/' . basename($file);

    if (file_exists($file_path)) {
        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

        switch ($file_extension) {
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            case 'docx':
                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                break;
            case 'xlsx':
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                break;
            default:
                header('Content-Type: application/octet-stream');
                break;
        }

        header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
        readfile($file_path);
    } else {
        echo 'File not found.';
    }
} else {
    echo 'No file specified.';
}
