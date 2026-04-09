<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pembeli</title>
</head>
<body>

    <h1>Dashboard Pembeli</h1>
    <p>Halo, <?= $nama; ?>!</p>
    <p>Role: <?= $role; ?></p>

    <ul>
        <li><a href="produk.php">Lihat Produk</a></li>
        <li><a href="keranjang.php">Keranjang</a></li>
        <li><a href="pesanan_saya.php">Pesanan Saya</a></li>
    </ul>

    <button onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')">Logout</button>

    <script src="../assets/js/script.js"></script>
</body>
</html>