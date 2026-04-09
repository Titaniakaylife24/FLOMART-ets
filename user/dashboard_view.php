<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard FLOMART</title>
</head>
<body>

<!-- JUDUL -->
<h1>Pilihan Benih Terbaik</h1>
<p>Pilih produk berdasarkan kategori yang kamu inginkan.</p>

<!-- KATEGORI -->
<div>
    <a href="dashboard.php">Semua</a>

    <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
        <a href="dashboard.php?kategori=<?= $kategori['id_kategori']; ?>">
            <?= $kategori['nama_kategori']; ?>
        </a>
    <?php endwhile; ?>
</div>

<hr>

<!-- PRODUK -->
<div>

<?php
function getBadge($index) {
    $badges = ['Best Seller', 'Terlaris', 'Hemat', 'Premium'];
    return $badges[$index % count($badges)];
}

function getRating($index) {
    $ratings = ['4.8', '4.9', '4.6', '4.8'];
    return $ratings[$index % count($ratings)];
}
?>

<?php $i = 0; ?>
<?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>

    <div>

        <!-- BADGE & RATING -->
        <div>
            <span><?= getBadge($i); ?></span>
            <span>⭐ <?= getRating($i); ?></span>
        </div>

        <!-- GAMBAR -->
        <div>
            <span>[GAMBAR]</span>
        </div>

        <!-- INFO -->
        <div>
            <p><?= $produk['nama_kategori']; ?></p>
            <h3><?= $produk['nama_produk']; ?></h3>

            <p>Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>

            <p>Siap tanam • Kualitas premium</p>
        </div>

        <!-- BUTTON -->
        <button>🛒</button>

    </div>

<?php $i++; ?>
<?php endwhile; ?>

</div>

</body>
</html>