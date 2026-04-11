<?php
include __DIR__ . '/../cek_login.php';
include __DIR__ . '/../koneksi/koneksi.php';

// SESSION DATA
$nama = $_SESSION['nama'] ?? 'Guest';
$isLogin = isset($_SESSION['id_user']);
$isPembeli = isset($_SESSION['role']) && $_SESSION['role'] === 'pembeli';

// KATEGORI HARUS DIAMBIL DULU
$kategoriAktif = $_GET['kategori'] ?? null;

// FILTER
$where = "";
if (!empty($kategoriAktif)) {
    $id_kategori = (int)$kategoriAktif;
    $where = "WHERE produk.id_kategori = $id_kategori";
}

// QUERY PRODUK
$queryProduk = "SELECT 
    produk.*, 
    kategori.nama_kategori,
    COALESCE(SUM(detail_pesanan.qty), 0) AS total_terjual
FROM produk
JOIN kategori ON produk.id_kategori = kategori.id_kategori
LEFT JOIN detail_pesanan 
    ON produk.id_produk = detail_pesanan.id_produk
$where
GROUP BY produk.id_produk
ORDER BY produk.id_produk DESC
";

$resultProduk = mysqli_query($conn, $queryProduk);

if (!$resultProduk) {
    die("Query produk error: " . mysqli_error($conn));
}

// QUERY KATEGORI
$queryKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

if (!$resultKategori) {
    die("Query kategori error: " . mysqli_error($conn));
}

// QUERY REKOMENDASI
$queryRekom = "SELECT 
    produk.*, 
    kategori.nama_kategori, 
    COALESCE(SUM(detail_pesanan.qty), 0) AS total_terjual
FROM produk
JOIN kategori ON produk.id_kategori = kategori.id_kategori
LEFT JOIN detail_pesanan 
    ON produk.id_produk = detail_pesanan.id_produk
GROUP BY produk.id_produk
ORDER BY total_terjual DESC
LIMIT 4
";

$resultRekomendasi = mysqli_query($conn, $queryRekom);

if (!$resultRekomendasi) {
    die("Query rekomendasi error: " . mysqli_error($conn));
}

//keranjang
$jumlahKeranjang = 0;

if ($isLogin) {
    $id_user = $_SESSION['id_user'];

    $queryKeranjang = "SELECT SUM(jumlah) as total FROM keranjang WHERE id_user = $id_user";
    $resultKeranjang = mysqli_query($conn, $queryKeranjang);

    if ($resultKeranjang) {
        $dataKeranjang = mysqli_fetch_assoc($resultKeranjang);
        $jumlahKeranjang = (int) ($dataKeranjang['total'] ?? 0);
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard FLOMART</title>
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 font-sans scroll-smooth">

<?php if (isset($_GET['success'])): ?>
    <script>
        alert("Produk berhasil ditambahkan ke keranjang!");
        window.history.replaceState({}, document.title, window.location.pathname);
    </script>
<?php endif; ?>

<!-- HEADER -->
<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow z-50">

    <!-- TOP BAR -->
    <div class="flex items-center justify-between px-10 py-4">

        <img src="../assets/img/LogoFlomart.png" width="150">

        <div class="flex items-center gap-8">

            <!-- MENU -->
            <nav class="flex items-center gap-6 text-gray-700 font-medium text-sm">

                <a href="#" class="hover:text-green-600">Chat</a>
                <a href="/FLOMART-ets/user/pesanan_saya.php" class="hover:text-green-600">Pesanan</a>
                <a href="#" class="hover:text-green-600">Notifikasi</a>

                <?php if ($isLogin): ?>
                    <a href="/FLOMART-ets/keranjang/index.php" class="hover:text-green-600">
                    Keranjang (<?= $jumlahKeranjang; ?>)
                    </a>
                <?php endif; ?>

                <!-- Avatar -->
                <div class="w-6 h-6 rounded-full border-2 border-green-500 
                flex items-center justify-center text-green-600 text-xs">
                    <?= strtoupper(substr($nama, 0, 1)); ?>
                </div>

            </nav>

            <?php if ($isLogin): ?>
                <button onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')"
                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Logout
                </button>
            <?php else: ?>
                <a href="/FLOMART-ets/login/login.php"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Login
                </a>
            <?php endif; ?>

        </div>
    </div>

    <!-- NAVBAR -->
<div class="px-10">
    <nav class="border-t-2 border-gray-200 py-3 flex justify-center gap-10 text-gray-700 font-medium">

        <a href="/FLOMART-ets/user/dashboard.php"
        class="text-green-600 border-b-2 border-green-600 pb-1">
            Beranda
        </a>

        <a href="#">Toko</a>
        <a href="/FLOMART-ets/admin/transit.php">Mulai Jualan</a>
        <a href="#">Blog</a>
        <a href="#">Tentang Kami</a>

    </nav>
</div>
</header>

<!-- CONTENT -->
<div class="pt-32 px-10 max-w-7xl mx-auto">

    <!-- GREETING -->
    <section class="mb-6 mt-10">
        <h1 class="text-4xl font-bold">
            Selamat datang, <?= htmlspecialchars($nama); ?>!
        </h1>
    </section>

    <!-- BANNER -->
    <section class="mb-12">

        <div class="rounded-2xl px-10 py-12 flex items-center justify-between
        bg-cover bg-center"
        style="background-image: url('../assets/img/BannerBg.png');">

            <div class="max-w-xl">
                <h1 class="text-4xl font-bold mb-6">
                    Belanja Pintar <br>
                    untuk Masa Depan <br>
                    yang Lebih Hijau
                </h1>

                <p class="text-gray-500 mb-6">
                    Temukan produk tanaman ramah lingkungan dari penjual terpercaya dengan proses belanja yang mudah dan aman
                </p>
            </div>

            <img src="../assets/img/FotoLogin.png" width="300">
        </div>

    </section>

    <!-- REKOMENDASI -->
    <section class="mb-12">

        <h2 class="text-2xl font-bold mb-2">Rekomendasi Benih Berkualitas</h2>
        <p class="text-gray-500 mb-6">Produk rekomendasi berdasarkan jumlah penjualan terbanyak.</p>

        <div class="grid grid-cols-4 gap-6">

        <?php while ($rekom = mysqli_fetch_assoc($resultRekomendasi)): ?>
            
            <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">

              <?php 
$gambarRekom = !empty($rekom['gambar']) 
    ? "/FLOMART-ets/uploads/produk/" . basename($rekom['gambar']) 
    : "/FLOMART-ets/assets/img/no-image.png";
?>

<div class="mb-4">
    <img src="<?= htmlspecialchars($gambarRekom); ?>" 
     class="w-full h-40 object-cover rounded-lg"
     onerror="this.src='/FLOMART-ets/assets/img/no-image.png'">
</div>
                <p class="text-xs text-gray-400">
                    <?= htmlspecialchars($rekom['nama_kategori']); ?>
                </p>

                <h3 class="font-semibold text-lg">
                    <?= htmlspecialchars($rekom['nama_produk']); ?>
                </h3>

                <p class="text-green-600 font-bold">
                    Rp <?= number_format($rekom['harga'], 0, ',', '.'); ?>
                </p>

                <p class="text-xs text-gray-400 mb-3">
                    Terjual: <?= (int)$rekom['total_terjual']; ?>
                </p>

                <div class="flex justify-end">
                    <?php if ($isPembeli): ?>
                         <button 
                        onclick="openCartModal(<?= $rekom['id_produk']; ?>)"
                         class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500">
                        <img src="../assets/img/logoKeranjangPutih.png" width="23">
                        </button>
                    <?php else: ?>
                        <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $rekom['id_produk']); ?>
                        <button onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')"
                        class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500">
                            <img src="../assets/img/logoKeranjangPutih.png" alt="keranjang putih" width="23">
                        </button>
                    <?php endif; ?>
                </div>

            </div>

        <?php endwhile; ?>

        </div>

    </section>

   <!-- KATEGORI -->
<section class="mb-10">

    <h2 class="text-2xl font-bold mb-2">Pilihan Benih Terbaik</h2>
    <p class="text-gray-500 mb-4">Pilih produk berdasarkan kategori yang kamu inginkan.</p>

    <div class="flex gap-3 flex-wrap">

        <!-- Semua -->
       <?php $isAllActive = ($kategoriAktif == null); ?>

        <a href="/FLOMART-ets/user/dashboard.php#produk"
        class="px-4 py-2 rounded-full text-sm transition border
        <?= $isAllActive 
        ? 'bg-green-600 text-white border-green-600' 
        : 'bg-white border-gray-200 hover:bg-green-100 hover:text-green-700' ?>">
        Semua
        </a>

        <!-- LOOP KATEGORI -->
        <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>

            <?php 
                $isActive = ($kategoriAktif == $kategori['id_kategori']);
            ?>

            <a href="/FLOMART-ets/user/dashboard.php?kategori=<?= $kategori['id_kategori']; ?>#produk"
               class="px-4 py-2 rounded-full text-sm transition border
               <?= $isActive 
                    ? 'bg-green-600 text-white border-green-600' 
                    : 'bg-white border-gray-200 hover:bg-green-100 hover:text-green-700' ?>">
                <?= htmlspecialchars($kategori['nama_kategori']); ?>
            </a>

        <?php endwhile; ?>

    </div>

</section>
    <!-- PRODUK -->
<<<<<<< HEAD
    <section id="produk" class="mb-32">
=======
    <section class="mb-20">
>>>>>>> titania

        <div class="grid grid-cols-4 gap-6">

        <?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>

            <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">

             <?php 
$gambarProduk = !empty($produk['gambar']) 
    ? "/FLOMART-ets/uploads/produk/" . basename($produk['gambar']) 
    : "/FLOMART-ets/assets/img/no-image.png";
?>

<div class="mb-4">
    <img src="<?= htmlspecialchars($gambarProduk); ?>?v=<?= time(); ?>" 
    class="w-full h-40 object-cover rounded-lg"
    onerror="this.src='/FLOMART-ets/assets/img/no-image.png'">
</div>
                <p class="text-xs text-gray-400">
                    <?= htmlspecialchars($produk['nama_kategori']); ?>
                </p>

                <h3 class="font-semibold text-lg">
                    <?= htmlspecialchars($produk['nama_produk']); ?>
                </h3>

                <p class="text-green-600 font-bold">
                    Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>
                </p>

                <p class="text-xs text-gray-400 mb-3">
                    Terjual: <?= (int)$produk['total_terjual']; ?>
                </p>

                <div class="flex justify-end">
                    <?php if ($isPembeli): ?>
                       <button 
                        onclick="openCartModal(<?= $produk['id_produk']; ?>)"
                        class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500">
                        <img src="../assets/img/logoKeranjangPutih.png" width="23">
                        </button>

                    <?php else: ?>
                        <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $produk['id_produk']); ?>
                        <button onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')"
                        class="bg-yellow-400 p-2 rounded-full hover:bg-yellow-500">
                        <img src="../assets/img/logoKeranjangPutih.png" alt="Keranjang putih" width="23">
                        </button>
                    <?php endif; ?>
                </div>

            </div>

        <?php endwhile; ?>

        </div>

    </section>

</div>

<!-- FOOTER -->
 <div class="h-24"></div>
<footer class="bg-green-700 text-white py-14 mt-24">

    <div class="max-w-7xl mx-auto px-10">

        <div class="grid grid-cols-4 gap-10">

            <!-- BRAND -->
            <div>
                <img src="../assets/img/contrasLogoFlomart.png" width="150" class="mb-4">

                <p class="text-sm mb-4">
                    Marketplace tanaman ramah lingkungan terpercaya
                </p>

                <div class="flex">
                    <input type="email"
                    placeholder="Write Email"
                    class="px-3 py-2 rounded-l-lg text-black w-full bg-white">

                    <button class="bg-yellow-400 px-4 rounded-r-lg">
                        ➤
                    </button>
                </div>

                <p class="text-xs mt-6">
                    Copyright <br>
                    © 2025 FLOMART. All rights reserved. <br>
                    Grow green, live better.
                </p>
            </div>

            <!-- LAYANAN -->
            <div>
                <h3 class="font-semibold mb-4">Layanan</h3>
                <ul class="space-y-2 text-sm">
                    <li>Belanja Tanaman</li>
                    <li>Bibit & Media Tanaman</li>
                    <li>Filter Kecocokan Tanaman</li>
                    <li>Start Sell (jual tanaman)</li>
                </ul>
            </div>

            <!-- BANTUAN -->
            <div>
                <h3 class="font-semibold mb-4">Bantuan</h3>
                <ul class="space-y-2 text-sm">
                    <li>Cara Belanja</li>
                    <li>Cara Menjual Tanaman</li>
                    <li>Pengiriman & Perawatan</li>
                    <li>Kebijakan Pengembalian</li>
                </ul>
            </div>

            <!-- SOSIAL -->
            <div>
                <h3 class="font-semibold mb-4">Ikuti Kami</h3>
                <ul class="space-y-2 text-sm">
                    <li>Instagram - @flomart.id</li>
                    <li>Facebook - FLOMART</li>
                    <li>Twitter/X - @flomart_id</li>
                </ul>
            </div>

        </div>

    </div>

</footer>

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

function openCartModal(idProduk) {
    document.getElementById('productId').value = idProduk;
    document.getElementById('cartModal').classList.remove('hidden');
}

function closeCartModal() {
    document.getElementById('cartModal').classList.add('hidden');
}
</script>

<!-- CART MODAL -->
<div id="cartModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    
    <div class="bg-white rounded-xl p-6 w-80">

        <h2 class="text-lg font-bold mb-4">Tambah ke Keranjang</h2>

        <form method="POST" action="/FLOMART-ets/keranjang/tambah.php">

            <input type="hidden" name="id" id="productId">

            <label class="text-sm">Jumlah</label>
            <input type="number" name="qty" value="1" min="1"
                   class="w-full border rounded p-2 mb-4">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCartModal()"
                        class="px-3 py-1 bg-gray-300 rounded">
                    Batal
                </button>

                <button type="submit"
                        class="px-3 py-1 bg-green-600 text-white rounded">
                    Tambah
                </button>
            </div>

        </form>

    </div>
</div>

<!--Footer-->
   <footer class="bg-green-700 text-white py-14 mt-10">
    <div class="max-w-7xl mx-auto px-10">
        <div class="grid grid-cols-4 gap-10">
 <!-- BRAND -->
    <div>
        <img src="../assets/img/contrasLogoFlomart.png" width="150">

        <p class="text-sm mb-4">
            Marketplace tanaman ramah lingkungan terpercaya
        </p>

        <div class="flex">
            <input type="email"
            placeholder="Write Email"
            class="px-3 py-2 rounded-l-lg text-black w-full bg-white">

            <button class="bg-yellow-400 px-4 rounded-r-lg">
                ➤
            </button>
        </div>

        <p class="text-xs mt-6">
            Copyright <br>
            © 2025 FLOMART. All rights reserved. <br>
            Grow green, live better.
        </p>
    </div>

    <!-- LAYANAN -->
    <div>
        <h3 class="font-semibold mb-4">Layanan</h3>
        <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Belanja Tanaman</a></li>
            <li><a href="#" class="hover:underline">Bibit & Media Tanaman</a></li>
            <li><a href="#" class="hover:underline">Filter Kecocokan Tanaman</a></li>
            <li><a href="#" class="hover:underline">Start Sell (jual tanaman)</a></li>
        </ul>
    </div>

    <!-- BANTUAN -->
    <div>
        <h3 class="font-semibold mb-4">Bantuan</h3>
        <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Cara Belanja</a></li>
            <li><a href="#" class="hover:underline">Cara Menjual Tanaman</a></li>
            <li><a href="#" class="hover:underline">Pengiriman & Perawatan</a></li>
            <li><a href="#" class="hover:underline">Kebijakan Pengembalian</a></li>
        </ul>
    </div>

    <!-- SOSIAL -->
    <div>
        <h3 class="font-semibold mb-4">Ikuti Kami</h3>
        <ul class="space-y-2 text-sm">
            <li>Instagram - @flomart.id</li>
            <li>Facebook - FLOMART</li>
            <li>Twitter/X - @flomart_id</li>
        </ul>
    </div>

        </div>
    </div>
</footer>
</body>
</html>