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
$namaTampil = $isLogin && !empty($nama) ? $nama : 'Guest';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard FLOMART</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-gray-100 font-sans">

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- Header -->
    <header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow z-50">

        <!-- TOP BAR -->
        <div class="flex items-center justify-between px-10 py-4">

            <div>
                <img src="assets/img/LogoFlomart.png" alt="Logo Flomart" width="150">
            </div>
            
            <div class="flex items-center gap-8">

                <!-- SHORTCUT -->
                <nav class="flex items-center gap-6 text-gray-700 font-medium">

                    <a href="#" class="flex flex-col items-center hover:text-green-600 text-sm">
                        <span>Chat</span>
                    </a>

                    <a href="#" class="flex flex-col items-center hover:text-green-600 text-sm">
                        <span>Pesanan</span>
                    </a>

                    <a href="#" class="flex flex-col items-center hover:text-green-600 text-sm">
                        <span>Notifikasi</span>
                    </a>

                    <a href="#" class="flex flex-col items-center hover:text-green-600 text-sm">
                        <span>Keranjang</span>
                    </a>

                    <a href="#" class="flex flex-col items-center hover:text-green-600 text-sm">
                        <div class="w-6 h-6 rounded-full border-2 border-green-500 flex items-center justify-center text-green-600 text-xs">
                            <?= strtoupper(substr($namaTampil, 0, 1)); ?>
                        </div>
                    </a>

                </nav>

                <?php if ($isLogin): ?>
                    <a href="/FLOMART-ets/login/logout.php"
                       class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/FLOMART-ets/login/login.php"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Login
                    </a>
                <?php endif; ?>

            </div>
        </div>

        <!-- NAVBAR -->
        <nav class="border-t-2 border-gray-200 px-10 py-3 flex justify-center gap-10 text-gray-700 font-medium max-w-6xl mx-auto">
            <a href="/FLOMART-ets/index.php" class="text-green-600 border-b-2 border-green-600 pb-1">Beranda</a>
            <a href="#" class="hover:text-green-600">Toko</a>
            <a href="#" class="hover:text-green-600">Mulai Jualan</a>
            <a href="#" class="hover:text-green-600">Blog</a>
            <a href="#" class="hover:text-green-600">Tentang Kami</a>
        </nav>

    </header>

    <div class="pt-32 px-10">

        <!-- Greeting Dashboard -->
        <section class="mb-6">
            <h1 class="text-2xl font-bold">
                Selamat datang, <?= htmlspecialchars($namaTampil); ?>!
            </h1>
        </section>

        <!-- Banner Dashboard -->
        <section class="mb-12">
            <div class="rounded-2xl px-10 py-12 flex items-center justify-between bg-cover bg-center"
                 style="background-image: url('assets/img/BannerBg.png');">

                <div class="max-w-xl">
                    <h1 class="text-4xl font-bold leading-tight text-gray-900 mb-6">
                        Belanja Pintar <br>
                        untuk Masa Depan <br>
                        yang Lebih Hijau
                    </h1>

                    <p class="text-gray-500 mb-8 leading-relaxed">
                        Temukan produk tanaman ramah lingkungan <br>
                        dari penjual terpercaya dengan proses belanja <br>
                        yang mudah dan aman
                    </p>

                    <a href="#"
                       class="inline-block bg-yellow-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-600 transition">
                        Belanja Sekarang
                    </a>
                </div>

                <div class="w-[400px] h-[250px] rounded-xl flex items-center justify-center">
                    <img src="assets/img/FotoLogin.png" alt="Foto Dashboard" width="330">
                </div>

            </div>
        </section>

        <!-- Produk Terbaru -->
        <section class="mb-12">

            <div class="mb-6">
                <h2 class="text-2xl font-bold">Rekomendasi Benih Berkualitas</h2>
                <p class="text-gray-500">Produk pilihan dengan rating tinggi dan kategori beragam.</p>
            </div>

            <div class="grid grid-cols-4 gap-6">

                <?php $i = 0; ?>
                <?php while ($rekom = mysqli_fetch_assoc($resultRekomendasi)): ?>

                <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">

                    <div class="flex justify-between text-sm mb-3">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                            <?= getBadge($i); ?>
                        </span>
                        <span class="text-yellow-500 font-semibold">
                            ⭐ <?= getRating($i); ?>
                        </span>
                    </div>

                    <div class="text-5xl text-center mb-4">
                        <?= getEmoji($rekom['nama_produk']); ?>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-400">
                            <?= htmlspecialchars($rekom['nama_kategori']); ?>
                        </p>

                        <h3 class="font-semibold text-lg">
                            <?= htmlspecialchars($rekom['nama_produk']); ?>
                        </h3>

                        <p class="text-green-600 font-bold">
                            Rp <?= number_format($rekom['harga'], 0, ',', '.'); ?>
                        </p>

                        <p class="text-xs text-gray-400">
                            Siap tanam • Kualitas premium
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <?php if ($isPembeli): ?>
                            <a href="/FLOMART-ets/keranjang/tambah.php?id=<?= $rekom['id_produk']; ?>">
                                <button type="button" class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500 transition">
                                    <img src="assets/img/logoKeranjangPutih.png" alt="Keranjangputih" width="23">
                                </button>
                            </a>
                        <?php else: ?>
                            <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $rekom['id_produk']); ?>
                            <button type="button"
                                    onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')"
                                    class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500 transition">
                                <img src="assets/img/logoKeranjangPutih.png" alt="Keranjangputih" width="23">
                            </button>
                        <?php endif; ?>
                    </div>

                </div>

                <?php $i++; ?>
                <?php endwhile; ?>

            </div>

        </section>

        <!-- Kategori -->
        <section class="mb-10">

            <div class="mb-4">
                <h2 class="text-2xl font-bold">Pilihan Benih Terbaik</h2>
                <p class="text-gray-500">Pilih produk berdasarkan kategori yang kamu inginkan.</p>
            </div>

            <div class="flex gap-3 flex-wrap">

                <a href="/FLOMART-ets/index.php"
                   class="px-4 py-2 bg-green-600 text-white rounded-full text-sm">
                    Semua
                </a>

                <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>

                <a href="/FLOMART-ets/index.php?kategori=<?= $kategori['id_kategori']; ?>"
                   class="px-4 py-2 bg-white border rounded-full text-sm hover:bg-green-50 transition">
                    <?= htmlspecialchars($kategori['nama_kategori']); ?>
                </a>

                <?php endwhile; ?>

            </div>

        </section>

        <!-- Produk -->
        <section>

            <div class="grid grid-cols-4 gap-6">

                <?php $j = 0; ?>
                <?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>

                <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">

                    <div class="flex justify-between text-sm mb-3">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                            <?= getBadge($j); ?>
                        </span>
                        <span class="text-yellow-500 font-semibold">
                            ⭐ <?= getRating($j); ?>
                        </span>
                    </div>

                    <div class="text-5xl text-center mb-4">
                        <?= getEmoji($produk['nama_produk']); ?>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-400">
                            <?= htmlspecialchars($produk['nama_kategori']); ?>
                        </p>

                        <h3 class="font-semibold text-lg">
                            <?= htmlspecialchars($produk['nama_produk']); ?>
                        </h3>

                        <p class="text-green-600 font-bold">
                            Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>
                        </p>

                        <p class="text-xs text-gray-400">
                            Siap tanam • Kualitas premium
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <?php if ($isPembeli): ?>
                            <a href="/FLOMART-ets/keranjang/tambah.php?id=<?= $produk['id_produk']; ?>">
                                <button type="button" class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500 transition">
                                    <img src="assets/img/logoKeranjangPutih.png" alt="Keranjang in produk" width="23">
                                </button>
                            </a>
                        <?php else: ?>
                            <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $produk['id_produk']); ?>
                            <button type="button"
                                    onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')"
                                    class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500 transition">
                                <img src="assets/img/logoKeranjangPutih.png" alt="Keranjang in produk" width="23">
                            </button>
                        <?php endif; ?>
                    </div>

                </div>

                <?php $j++; ?>
                <?php endwhile; ?>

            </div>

        </section>

    </div>
</div>

<script>
function konfirmasiLogin(loginUrl) {
    if (confirm("Anda harus login terlebih dahulu. Login sekarang?")) {
        window.location.href = loginUrl;
    }
}
</script>

</body>
</html>