<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__.'/../koneksi/koneksi.php';
$engine = $connect->query("SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 't_siswa'")->fetch_assoc();
if (($engine['ENGINE'] ?? '') !== 'InnoDB') {
    exit("Tes dibatalkan: rollback memerlukan tabel InnoDB.\n");
}
$connect->begin_transaction();
try {
    $nis = 'T'.bin2hex(random_bytes(5));
    $nama = "Uji O'Connor <b>teks</b>";
    $kelas = 'XI';
    $jk = 'L';
    $alamat = 'Alamat uji sementara';
    $statement = $connect->prepare('INSERT INTO t_siswa (NIS, NAMA, KELAS, JK, ALAMAT) VALUES (?, ?, ?, ?, ?)');
    $statement->bind_param('sssss', $nis, $nama, $kelas, $jk, $alamat);
    $statement->execute();
    $id = $connect->insert_id;
    $statement = $connect->prepare('SELECT NAMA FROM t_siswa WHERE ID = ?');
    $statement->bind_param('i', $id);
    $statement->execute();
    if ($statement->get_result()->fetch_assoc()['NAMA'] !== $nama) {
        throw new RuntimeException('Create/read gagal.');
    }
    echo "PASS Create dan Read, termasuk tanda petik dan HTML\n";
    $alamat = 'Alamat diperbarui';
    $statement = $connect->prepare('UPDATE t_siswa SET NIS = ?, NAMA = ?, KELAS = ?, JK = ?, ALAMAT = ? WHERE ID = ?');
    $statement->bind_param('sssssi', $nis, $nama, $kelas, $jk, $alamat, $id);
    $statement->execute();
    if ($statement->affected_rows !== 1) {
        throw new RuntimeException('Update gagal.');
    }
    echo "PASS Update\n";
    $statement = $connect->prepare('DELETE FROM t_siswa WHERE ID = ?');
    $statement->bind_param('i', $id);
    $statement->execute();
    if ($statement->affected_rows !== 1) {
        throw new RuntimeException('Delete gagal.');
    }
    echo "PASS Delete\n";
} finally {
    $connect->rollback();
    echo "Transaksi dibatalkan; data siswa asli tidak diubah.\n";
}
