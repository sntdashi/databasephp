<?php

require_once __DIR__.'/fungsi.php';
require_once __DIR__.'/koneksi/koneksi.php';

$query = $connect->query('SELECT ID, NIS, NAMA, KELAS, JK, ALAMAT FROM t_siswa ORDER BY ID DESC');
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);
$judul = 'Data Siswa';
include __DIR__.'/views/header.php';
include __DIR__.'/views/datasiswa.php';
include __DIR__.'/views/footer.php';
