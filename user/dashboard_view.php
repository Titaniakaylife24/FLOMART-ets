<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pembeli - FLOMART</title>
</head>
<body>

    <h1>Selamat datang, <?= $nama; ?>!</h1>
    <p>Role: <?= $role; ?></p>

    <h2>Rekomendasi Benih Berkualitas</h2>
    <p>Produk pilihan FLOMART dengan stok tersedia dan kategori beragam.</p>

    <?php if (mysqli_num_rows($resultRekomendasi) > 0): ?>
       <div style="display:flex; flex-wrap:wrap; gap:20px; margin-bottom:40px;">
            <?php while ($rekom = mysqli_fetch_assoc($resultRekomendasi)): ?>
                <div style="border:1px solid #ccc; padding:15px; width:220px; border-radius:10px;">
                    <p><strong><?= $rekom['nama_kategori']; ?></strong></p>
                    <h3><?= $rekom['nama_produk']; ?></h3>
                    <p>Rp <?= number_format($rekom['harga'], 0, ',', '.'); ?></p>
                    <p>Stok: <?= $rekom['stok']; ?></p>

                    <?php if (!empty($rekom['gambar'])): ?>
                        <img src="../assets/img/<?= $rekom['gambar']; ?>" width="120">
                    <?php else: ?>
                        <p>Tidak ada gambar</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Belum ada produk rekomendasi.</p>
    <?php endif; ?>
    
    <h2>Kategori Produk</h2>
    <ul>
    <li>
        <a href="dashboard.php" <?= ($id_kategori == 0) ? 'style="font-weight:bold; color:green;"' : ''; ?>>
            Semua
        </a>
    </li>

    <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
        <li>
            <a href="dashboard.php?kategori=<?= $kategori['id_kategori']; ?>"
               <?= ($id_kategori == $kategori['id_kategori']) ? 'style="font-weight:bold; color:green;"' : ''; ?>>
                <?= $kategori['nama_kategori']; ?>
            </a>
        </li>
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