<?php if (! isset($data, $aksi)) {
    http_response_code(404);
    exit;
} ?>
<a class="back" href="index.php">← Kembali ke daftar siswa</a>
<section class="panel compact">
    <p class="eyebrow">INFORMASI SISWA</p><h1><?= escape($judul) ?></h1><p>Lengkapi seluruh kolom di bawah ini.</p>
    <?php if ($errors !== []) { ?><div class="notice error" role="alert"><ul><?php foreach ($errors as $error) { ?><li><?= escape($error) ?></li><?php } ?></ul></div><?php } ?>
    <form action="<?= escape($aksi) ?>" method="post">
        <input type="hidden" name="csrf" value="<?= escape($_SESSION['csrf']) ?>">
        <div class="form-grid">
            <label>NIS<input name="NIS" maxlength="11" value="<?= escape($data['NIS']) ?>" required placeholder="Contoh: 2018004"></label>
            <label>Nama lengkap<input name="NAMA" maxlength="100" value="<?= escape($data['NAMA']) ?>" required placeholder="Nama siswa"></label>
            <label>Kelas<input name="KELAS" maxlength="10" value="<?= escape($data['KELAS']) ?>" required placeholder="Contoh: XI"></label>
            <label>Jenis kelamin<select name="JK" required><option value="">Pilih jenis kelamin</option><option value="L" <?= $data['JK'] === 'L' ? 'selected' : '' ?>>Laki-laki</option><option value="P" <?= $data['JK'] === 'P' ? 'selected' : '' ?>>Perempuan</option></select></label>
            <label class="full">Alamat<textarea name="ALAMAT" rows="4" maxlength="16000" required placeholder="Alamat lengkap siswa"><?= escape($data['ALAMAT']) ?></textarea></label>
        </div>
        <div class="actions"><button type="submit"><?= isset($id) ? 'Simpan perubahan' : 'Simpan siswa' ?></button><a class="button secondary" href="index.php">Batal</a></div>
    </form>
</section>
