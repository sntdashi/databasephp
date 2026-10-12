<?php if (! isset($judul)) {
    http_response_code(404);
    exit;
} ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escape($judul) ?> · Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar"><div class="container"><a class="brand" href="index.php"><span class="logo">DS</span> Data Siswa</a><span class="subtitle">Sistem Informasi Siswa</span></div></header>
<main class="container">
