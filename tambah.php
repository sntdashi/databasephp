<?php

require_once __DIR__.'/fungsi.php';
require_once __DIR__.'/koneksi/koneksi.php';

$data = ['NIS' => '', 'NAMA' => '', 'KELAS' => '', 'JK' => '', 'ALAMAT' => ''];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    periksaToken();
    $data = bacaForm();
    $errors = validasi($data);
    if ($errors === []) {
        $statement = $connect->prepare('INSERT INTO t_siswa (NIS, NAMA, KELAS, JK, ALAMAT) VALUES (?, ?, ?, ?, ?)');
        $statement->bind_param('sssss', $data['NIS'], $data['NAMA'], $data['KELAS'], $data['JK'], $data['ALAMAT']);
        $statement->execute();
        selesai('Data siswa berhasil ditambahkan.');
    }
    http_response_code(422);
}
$judul = 'Tambah Siswa';
$aksi = 'tambah.php';
include __DIR__.'/views/header.php';
include __DIR__.'/views/form.php';
include __DIR__.'/views/footer.php';
