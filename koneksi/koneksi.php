<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Sesuaikan pengaturan ini dengan MySQL di XAMPP kamu.
$host = getenv('SISWA_DB_HOST') ?: '127.0.0.1';
$username = getenv('SISWA_DB_USER') ?: 'root';
$password = getenv('SISWA_DB_PASSWORD') ?: '';
$db = getenv('SISWA_DB_NAME') ?: 'db_siswa';
$port = (int) (getenv('SISWA_DB_PORT') ?: 3306);

try {
    $connect = new mysqli($host, $username, $password, $db, $port);
    $connect->set_charset('utf8mb4');
} catch (mysqli_sql_exception $exception) {
    error_log($exception->getMessage());
    http_response_code(503);
    exit('Koneksi database gagal. Pastikan MySQL aktif, database db_siswa tersedia, dan pengaturan koneksi/koneksi.php sesuai.');
}
