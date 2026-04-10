<?php
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
<nav>
    <a href="/FLOMART-ets/user/dashboard.php">Dashboard</a> |
    
    <?php if (isset($_SESSION['id_user'])): ?>
        <a href="/FLOMART-ets/keranjang/index.php">Keranjang</a> |
        <button onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')">Logout</button>
    <?php else: ?>
        <a href="/FLOMART-ets/login/login.php">Login</a>
    <?php endif; ?>
</nav>

<h1>Selamat datang, <?= htmlspecialchars($nama); ?>!</h1>

<?php if ($isLogin): ?>
    <button type="button" onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')">Logout</button>
<?php else: ?>
    <a href="/FLOMART-ets/login/login.php">Login</a>
<?php endif; ?>

<h2>Rekomendasi Benih Berkualitas</h2>
<p>Produk rekomendasi berdasarkan jumlah penjualan terbanyak.</p>

<div>
    <?php while ($rekom = mysqli_fetch_assoc($resultRekomendasi)): ?>
        <div>
            <div>
                <span><?= getEmoji($rekom['nama_produk']); ?></span>
            </div>

            <div>
                <p><?= htmlspecialchars($rekom['nama_kategori']); ?></p>
                <h3><?= htmlspecialchars($rekom['nama_produk']); ?></h3>
                <p>Rp <?= number_format($rekom['harga'], 0, ',', '.'); ?></p>
                <p>Terjual: <?= (int)$rekom['total_terjual']; ?></p>
            </div>

            <?php if ($isPembeli): ?>
                <a href="/FLOMART-ets/keranjang/tambah.php?id=<?= $rekom['id_produk']; ?>">
                    <button type="button">🛒</button>
                </a>
            <?php else: ?>
                <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $rekom['id_produk']); ?>
                <button type="button" onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')">🛒</button>
            <?php endif; ?>
        </div>
        <br>
    <?php endwhile; ?>
</div>

<hr>

<h2>Pilihan Benih Terbaik</h2>
<p>Pilih produk berdasarkan kategori yang kamu inginkan.</p>

<div>
    <a href="/FLOMART-ets/user/dashboard.php"><strong>Semua</strong></a>

    <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
        <a href="/FLOMART-ets/user/dashboard.php?kategori=<?= $kategori['id_kategori']; ?>">
            <?= htmlspecialchars($kategori['nama_kategori']); ?>
        </a>
    <?php endwhile; ?>
</div>

<hr>

<div>
    <?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>
        <div>
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
                <a href="/FLOMART-ets/keranjang/tambah.php?id=<?= $produk['id_produk']; ?>">
                    <button type="button">🛒</button>
                </a>
            <?php else: ?>
                <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $produk['id_produk']); ?>
                <button type="button" onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')">🛒</button>
            <?php endif; ?>
        </div>
        <br>
    <?php endwhile; ?>
</div>

<script>
function konfirmasiLogin(loginUrl) {
    if (confirm("Anda harus login terlebih dahulu. Login sekarang?")) {
        window.location.href = loginUrl;
    }
}

function konfirmasiLogout(urlLogout) {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = urlLogout;
    }
}
</script>

</body>
</html>