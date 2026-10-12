<?php

require_once __DIR__.'/fungsi.php';
$id = ambilId();
require_once __DIR__.'/koneksi/koneksi.php';
$data = ambilSiswa($connect, $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    periksaToken();
    $statement = $connect->prepare('DELETE FROM t_siswa WHERE ID = ?');
    $statement->bind_param('i', $id);
    $statement->execute();
    selesai('Data siswa berhasil dihapus.');
}
$judul = 'Hapus Siswa';
include __DIR__.'/views/header.php';
?>
<section class="panel compact">
    <p class="eyebrow">KONFIRMASI PENGHAPUSAN</p>
    <h1>Hapus data siswa?</h1>
    <p>Data <strong><?= escape($data['NAMA']) ?></strong> (NIS <?= escape($data['NIS']) ?>) akan dihapus. Tindakan ini tidak dapat dibatalkan.</p>
    <form action="delete.php?id=<?= $id ?>" method="post" class="actions">
        <input type="hidden" name="csrf" value="<?= escape($_SESSION['csrf']) ?>">
        <button type="submit" class="danger">Ya, hapus siswa</button>
        <a class="button secondary" href="index.php">Batal</a>
    </form>
</section>
<?php include __DIR__.'/views/footer.php'; ?>
