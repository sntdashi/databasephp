<?php

require_once __DIR__.'/fungsi.php';
$id = ambilId();
require_once __DIR__.'/koneksi/koneksi.php';
$data = ambilSiswa($connect, $id);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    periksaToken();
    $data = bacaForm();
    $errors = validasi($data);
    if ($errors === []) {
        $statement = $connect->prepare('UPDATE t_siswa SET NIS = ?, NAMA = ?, KELAS = ?, JK = ?, ALAMAT = ? WHERE ID = ?');
        $statement->bind_param('sssssi', $data['NIS'], $data['NAMA'], $data['KELAS'], $data['JK'], $data['ALAMAT'], $id);
        $statement->execute();
        selesai('Perubahan data siswa berhasil disimpan.');
    }
    http_response_code(422);
}
$judul = 'Edit Siswa';
$aksi = 'edit.php?id='.$id;
include __DIR__.'/views/header.php';
include __DIR__.'/views/form.php';
include __DIR__.'/views/footer.php';
