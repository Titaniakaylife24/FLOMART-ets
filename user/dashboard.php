<?php
include '../cek_login.php';
cekRole('pembeli');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
</head>
<body>
    <h1>Dashboard Pembeli</h1>
    <p>Halo, <?= $_SESSION['nama']; ?>!</p>
    <p>Role: <?= $_SESSION['role']; ?></p>

    <ul>
        <li>Lihat Produk</li>
        <li>Keranjang</li>
        <li>Pesanan Saya</li>
    </ul>

    <a href="../login/logout.php">Logout</a>
</body>
</html>