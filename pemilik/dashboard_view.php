<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pemilik</title>
</head>
<body>

    <h1>Dashboard Pemilik</h1>
    <p>Halo, <?= $nama; ?>!</p>
    <p>Role: <?= $role; ?></p>

    <ul>
        <li>Laporan Penjualan</li>
        <li>Produk Terlaris</li>
    </ul>

    <button onclick="konfirmasiLogout()">Logout</button>

    <script src="../assets/js/script.js"></script>
</body>
</html>