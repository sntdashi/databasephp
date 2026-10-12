<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$_SESSION['csrf'] ??= bin2hex(random_bytes(32));

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function periksaToken(): void
{
    $token = $_POST['csrf'] ?? '';
    if (! is_string($token) || ! hash_equals($_SESSION['csrf'], $token)) {
        http_response_code(403);
        exit('Form kedaluwarsa. Muat ulang halaman lalu coba lagi.');
    }
}

/** @return array{NIS: string, NAMA: string, KELAS: string, JK: string, ALAMAT: string} */
function bacaForm(): array
{
    $data = [];
    foreach (['NIS', 'NAMA', 'KELAS', 'JK', 'ALAMAT'] as $kolom) {
        $nilai = $_POST[$kolom] ?? '';
        $data[$kolom] = is_string($nilai) ? trim($nilai) : '';
    }

    return $data;
}

/** @param array<string, string> $data
 * @return list<string>
 */
function validasi(array $data): array
{
    $errors = [];
    foreach (['NIS' => 11, 'NAMA' => 100, 'KELAS' => 10, 'ALAMAT' => 16000] as $kolom => $batas) {
        if ($data[$kolom] === '') {
            $errors[] = $kolom.' wajib diisi.';
        } elseif (mb_strlen($data[$kolom], 'UTF-8') > $batas) {
            $errors[] = $kolom.' maksimal '.$batas.' karakter.';
        }
    }
    if (! in_array($data['JK'], ['L', 'P'], true)) {
        $errors[] = 'Pilih jenis kelamin yang valid.';
    }

    return $errors;
}

function ambilId(): int
{
    $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($id === false || $id === null) {
        http_response_code(400);
        exit('ID tidak ditemukan atau tidak valid.');
    }

    return $id;
}

/** @return array<string, mixed> */
function ambilSiswa(mysqli $connect, int $id): array
{
    $statement = $connect->prepare('SELECT ID, NIS, NAMA, KELAS, JK, ALAMAT FROM t_siswa WHERE ID = ?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $data = $statement->get_result()->fetch_assoc();
    if ($data === null) {
        http_response_code(404);
        exit('Data siswa tidak ditemukan.');
    }

    return $data;
}

function selesai(string $pesan): never
{
    $_SESSION['pesan'] = $pesan;
    header('Location: index.php', true, 303);
    exit;
}

set_exception_handler(function (Throwable $exception): void {
    error_log((string) $exception);
    http_response_code(500);
    echo 'Proses gagal. Periksa tabel t_siswa dan koneksi database, lalu coba lagi.';
});
