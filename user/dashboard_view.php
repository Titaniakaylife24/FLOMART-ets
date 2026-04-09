<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pembeli - FLOMART</title>
</head>
<body>

    <h1>Selamat datang, <?= $nama; ?>!</h1>
    <p>Role: <?= $role; ?></p>

    <h2>Kategori Produk</h2>
    <ul>
        <li><a href="dashboard.php">Semua</a></li>
        <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
            <li><?= $kategori['nama_kategori']; ?></li>
        <?php endwhile; ?>
    </ul>

    <h2>Produk FLOMART</h2>

    <?php if (mysqli_num_rows($resultProduk) > 0): ?>
        <div style="display:flex; flex-wrap:wrap; gap:20px;">
            <?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>
                <div style="border:1px solid #ccc; padding:15px; width:220px; border-radius:10px;">
                    <p><strong><?= $produk['nama_kategori']; ?></strong></p>
                    <h3><?= $produk['nama_produk']; ?></h3>
                    <p>Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
                    <p>Stok: <?= $produk['stok']; ?></p>
                    <p><?= $produk['deskripsi']; ?></p>

                    <?php if (!empty($produk['gambar'])): ?>
                        <img src="../assets/img/<?= $produk['gambar']; ?>" width="120">
                    <?php else: ?>
                        <p>Tidak ada gambar</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Belum ada produk.</p>
    <?php endif; ?>

    <button onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')">Logout</button>

    <script src="../assets/js/script.js"></script>
</body>
</html>