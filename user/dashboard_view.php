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
        <li>Lihat Produk</li>
        <li>Keranjang</li>
        <li>Pesanan Saya</li>
    </ul>

    <button onclick="konfirmasiLogout()">Logout</button>

    <script src="../assets/js/script.js"></script>
</body>
</html>