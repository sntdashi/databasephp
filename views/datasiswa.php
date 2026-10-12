<?php if (! isset($query)) {
    http_response_code(404);
    exit;
} ?>
<div class="heading"><div><p class="eyebrow">DIREKTORI SISWA</p><h1>Data siswa</h1><p>Kelola identitas dan informasi siswa dalam satu tempat.</p></div><a class="button" href="tambah.php">+ Tambah siswa</a></div>
<?php if ($pesan !== '') { ?><div class="notice" role="status"><?= escape($pesan) ?></div><?php } ?>
<section class="panel">
    <div class="panel-title"><h2>Daftar siswa</h2><span class="badge"><?= $query->num_rows ?> siswa</span></div>
    <div class="table-scroll"><table>
        <thead><tr><th>NIS</th><th>Nama siswa</th><th>Kelas</th><th>Jenis kelamin</th><th>Alamat</th><th>Aksi</th></tr></thead>
        <tbody>
        <?php if ($query->num_rows === 0) { ?><tr><td colspan="6" class="empty">Belum ada data siswa. Klik Tambah siswa untuk memulai.</td></tr><?php } ?>
        <?php while ($result = $query->fetch_assoc()) { ?>
            <tr>
                <td><?= escape($result['NIS']) ?></td>
                <td class="student-name"><?= escape($result['NAMA']) ?></td>
                <td><?= escape($result['KELAS']) ?></td>
                <td><?= escape(match ($result['JK']) {
                    'L' => 'Laki-laki', 'P' => 'Perempuan', default => $result['JK']
                }) ?></td>
                <td class="address"><?= nl2br(escape($result['ALAMAT'])) ?></td>
                <td><div class="row-actions"><a href="edit.php?id=<?= (int) $result['ID'] ?>">Edit</a><a class="delete-link" href="delete.php?id=<?= (int) $result['ID'] ?>">Hapus</a></div></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
</section>
