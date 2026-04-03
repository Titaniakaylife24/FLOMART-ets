<?php
include '../cek_login.php';
cekRole('admin');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Dashboard Admin</h1>
    <p>Halo, <?= $_SESSION['nama']; ?>!</p>
    <p>Role: <?= $_SESSION['role']; ?></p>

    <ul>
        <li>Kelola Produk</li>
        <li>Kelola Kategori</li>
        <li>Kelola Pesanan</li>
    </ul>

    <button onclick="konfirmasiLogout()">Logout</button>
    <script src="../assets/js/script.js"></script>
</body>
</html>