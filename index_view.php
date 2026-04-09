<?php
function getBadge($index) {
    $badges = ['Best Seller', 'Terlaris', 'Hemat', 'Premium', 'Populer'];
    return $badges[$index % count($badges)];
}

function getRating($index) {
    $ratings = ['4.8', '4.9', '4.6', '4.8', '4.5'];
    return $ratings[$index % count($ratings)];
}

function getEmoji($namaProduk) {
    $nama = strtolower($namaProduk);

    if (strpos($nama, 'kubis') !== false) return '🥬';
    if (strpos($nama, 'sawi') !== false) return '🥗';
    if (strpos($nama, 'labu') !== false) return '🎃';
    if (strpos($nama, 'tomat') !== false) return '🍅';
    if (strpos($nama, 'jagung') !== false) return '🌽';
    if (strpos($nama, 'mint') !== false) return '🌿';
    if (strpos($nama, 'mawar') !== false) return '🌹';
    if (strpos($nama, 'kelengkeng') !== false) return '🥭';

    return '🌱';
}

$isLogin = isset($_SESSION['id_user']);
$isPembeli = isset($_SESSION['role']) && $_SESSION['role'] === 'pembeli';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard FLOMART</title>
</head>
<body>

<h1>Selamat datang, <?= htmlspecialchars($nama); ?>!</h1>

<?php if ($isLogin): ?>
    <button onclick="konfirmasiLogout('login/logout.php')">Logout</button>
<?php else: ?>
    <a href="login/login.php">Login</a>
<?php endif; ?>

<script src="assets/js/script.js"></script>

<!-- REKOMENDASI -->
<h2>Rekomendasi Benih Berkualitas</h2>
<p>Produk pilihan dengan rating tinggi dan kategori beragam.</p>

<div>
    <?php $i = 0; ?>
    <?php while ($rekom = mysqli_fetch_assoc($resultRekomendasi)): ?>
        <div>
            <div>
                <span><?= getBadge($i); ?></span>
                <span>⭐ <?= getRating($i); ?></span>
            </div>

            <div>
                <span><?= getEmoji($rekom['nama_produk']); ?></span>
            </div>

            <div>
                <p><?= htmlspecialchars($rekom['nama_kategori']); ?></p>
                <h3><?= htmlspecialchars($rekom['nama_produk']); ?></h3>
                <p>Rp <?= number_format($rekom['harga'], 0, ',', '.'); ?></p>
                <p>Siap tanam • Kualitas premium</p>
            </div>

            <?php if ($isPembeli): ?>
    <a href="keranjang/tambah.php?id=<?= $rekom['id_produk']; ?>">
        <button type="button">🛒</button>
    </a>
<?php else: ?>
    <?php $redirect = "keranjang/tambah.php?id=" . $rekom['id_produk']; ?>
    <button type="button" onclick="harusLogin('<?= htmlspecialchars($redirect, ENT_QUOTES); ?>')">🛒</button>
<?php endif; ?>
        </div>
        <br>
        <?php $i++; ?>
    <?php endwhile; ?>
</div>

<hr>

<!-- PRODUK UTAMA -->
<h2>Pilihan Benih Terbaik</h2>
<p>Pilih produk berdasarkan kategori yang kamu inginkan.</p>

<div>
    <a href="dashboard.php"><strong>Semua</strong></a>

    <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
        <a href="/FLOMART-ets/index.php?kategori=<?= $kategori['id_kategori']; ?>">
            <?= htmlspecialchars($kategori['nama_kategori']); ?>
        </a>
    <?php endwhile; ?>
</div>

<hr>

<div>
    <?php $j = 0; ?>
    <?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>
        <div>
            <div>
                <span><?= getBadge($j); ?></span>
                <span>⭐ <?= getRating($j); ?></span>
            </div>

            <div>
                <span><?= getEmoji($produk['nama_produk']); ?></span>
            </div>

            <div>
                <p><?= htmlspecialchars($produk['nama_kategori']); ?></p>
                <h3><?= htmlspecialchars($produk['nama_produk']); ?></h3>
                <p>Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
                <p>Siap tanam • Kualitas premium</p>
            </div>

            <?php if ($isPembeli): ?>
    <a href="keranjang/tambah.php?id=<?= $produk['id_produk']; ?>">
        <button type="button">🛒</button>
    </a>
<?php else: ?>
    <?php $redirect = "keranjang/tambah.php?id=" . $produk['id_produk']; ?>
    <button type="button" onclick="harusLogin('<?= htmlspecialchars($redirect, ENT_QUOTES); ?>')">🛒</button>
<?php endif; ?>
        </div>
        <br>
        <?php $j++; ?>
    <?php endwhile; ?>
</div>

</body>
</html>