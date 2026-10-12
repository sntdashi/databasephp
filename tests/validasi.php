<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__.'/../fungsi.php';

$valid = ['NIS' => '0012345', 'NAMA' => "Dwi O'Connor", 'KELAS' => 'XI', 'JK' => 'P', 'ALAMAT' => 'Jl. Pendidikan'];
$cases = [
    'Data lengkap diterima' => validasi($valid) === [],
    'NIS wajib diisi' => count(validasi(array_replace($valid, ['NIS' => '']))) === 1,
    'Nama wajib diisi' => count(validasi(array_replace($valid, ['NAMA' => '']))) === 1,
    'Kelas wajib diisi' => count(validasi(array_replace($valid, ['KELAS' => '']))) === 1,
    'Alamat wajib diisi' => count(validasi(array_replace($valid, ['ALAMAT' => '']))) === 1,
    'NIS terlalu panjang ditolak' => count(validasi(array_replace($valid, ['NIS' => str_repeat('1', 12)]))) === 1,
    'Nama terlalu panjang ditolak' => count(validasi(array_replace($valid, ['NAMA' => str_repeat('a', 101)]))) === 1,
    'Kelas terlalu panjang ditolak' => count(validasi(array_replace($valid, ['KELAS' => str_repeat('a', 11)]))) === 1,
    'Jenis kelamin tidak valid ditolak' => count(validasi(array_replace($valid, ['JK' => 'X']))) === 1,
    'HTML ditampilkan sebagai teks' => escape('<script>') === '&lt;script&gt;',
];
$_POST = array_replace($valid, ['NAMA' => '   ', 'NIS' => ['invalid']]);
$cases['Spasi dan input array ditolak'] = count(validasi(bacaForm())) === 2;
foreach ($cases as $name => $passed) {
    echo ($passed ? 'PASS' : 'FAIL').' '.$name.PHP_EOL;
}
exit(in_array(false, $cases, true) ? 1 : 0);
