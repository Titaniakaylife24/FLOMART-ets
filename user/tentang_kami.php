<?php
include __DIR__ . '/../cek_login.php';
include __DIR__ . '/../koneksi/koneksi.php';

// SESSION DATA
$nama = $_SESSION['nama'] ?? 'Guest';
$isLogin = isset($_SESSION['id_user']);

// keranjang
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
    <title>FLOMART - Tentang Kami</title>
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 font-sans scroll-smooth">

<!-- HEADER -->
<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow z-50">

    <!-- TOP BAR -->
    <div class="flex items-center justify-between px-10 py-4">

        <img src="../assets/img/LogoFlomart.png" width="150" alt="Logo FLOMART">

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
                <div class="w-6 h-6 rounded-full border-2 border-green-500 flex items-center justify-center text-green-600 text-xs">
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

            <a href="/FLOMART-ets/user/dashboard.php" class="hover:text-green-600">
                Beranda
            </a>

            <a href="/FLOMART-ets/admin/transit.php">Mulai Jualan</a>
            <a href="/FLOMART-ets/user/tentang_kami.php"
               class="text-green-600 border-b-2 border-green-600 pb-1">
                Tentang Kami
            </a>

        </nav>
    </div>
</header>

<!-- CONTENT -->
<div class="pt-32 px-10 max-w-7xl mx-auto">

    <!-- JUDUL -->
    <section class="mb-6 mt-10">
        <h1 class="text-4xl font-bold">
            Tentang Kami
        </h1>
        <p class="text-gray-500 mt-2">
            Mengenal lebih dekat FLOMART dan komitmen kami dalam menghadirkan pengalaman belanja tanaman yang mudah, aman, dan ramah lingkungan.
        </p>
    </section>

    <!-- BANNER -->
    <section class="mb-12">
        <div class="rounded-2xl px-10 py-12 flex items-center justify-between bg-cover bg-center"
             style="background-image: url('../assets/img/BannerBg.png');">

            <div class="max-w-2xl">
                <h2 class="text-4xl font-bold mb-6">
                    Tumbuh Hijau <br>
                    Bersama FLOMART
                </h2>

                <p class="text-gray-500 mb-6">
                    FLOMART adalah marketplace tanaman ramah lingkungan yang menghubungkan pembeli dengan penjual terpercaya
                    dalam satu platform digital yang nyaman dan mudah digunakan.
                </p>
            </div>

            <img src="../assets/img/FotoLogin.png" width="300" alt="Tentang FLOMART">
        </div>
    </section>

    <!-- SIAPA KAMI -->
    <section class="mb-12">
        <div class="bg-white rounded-2xl shadow-md p-8">
            <h2 class="text-2xl font-bold mb-4">Siapa Kami?</h2>
            <p class="text-gray-600 leading-relaxed">
                FLOMART hadir untuk membantu masyarakat menemukan berbagai tanaman, benih, dan kebutuhan berkebun
                dari penjual terpercaya. Kami juga ingin mendukung UMKM lokal agar berkembang lebih luas melalui
                platform digital yang modern, aman, dan mudah diakses oleh semua orang.
            </p>
        </div>
    </section>

    <!-- VISI & MISI -->
    <section class="mb-12 grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-md p-8">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl mb-4">
                🌱
            </div>
            <h2 class="text-2xl font-bold mb-4">Visi</h2>
            <p class="text-gray-600 leading-relaxed">
                Menjadi marketplace tanaman terpercaya yang mendorong masyarakat untuk hidup lebih hijau,
                sehat, dan berkelanjutan.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-8">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center text-xl mb-4">
                🚀
            </div>
            <h2 class="text-2xl font-bold mb-4">Misi</h2>
            <ul class="text-gray-600 space-y-3 leading-relaxed list-disc pl-5">
                <li>Menyediakan produk tanaman berkualitas dari penjual terpercaya.</li>
                <li>Mendukung pertumbuhan UMKM dan penjual lokal.</li>
                <li>Memberikan pengalaman belanja yang aman dan nyaman.</li>
                <li>Mendorong gaya hidup ramah lingkungan melalui platform digital.</li>
            </ul>
        </div>

    </section>

    <!-- NILAI -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Nilai yang Kami Bawa</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="text-3xl mb-3">💚</div>
                <h3 class="text-lg font-semibold mb-2">Ramah Lingkungan</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Kami mendukung gaya hidup hijau melalui produk tanaman dan kebutuhan berkebun berkualitas.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="text-3xl mb-3">🤝</div>
                <h3 class="text-lg font-semibold mb-2">Terpercaya</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Kami membangun hubungan yang aman dan nyaman antara pembeli dan penjual.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="text-3xl mb-3">🌼</div>
                <h3 class="text-lg font-semibold mb-2">Bertumbuh Bersama</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    FLOMART tumbuh bersama komunitas pecinta tanaman, UMKM, dan penjual lokal.
                </p>
            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="mb-20">
    <div class="bg-green-700 text-white rounded-2xl shadow-md px-12 py-12 w-full text-center">
        <h2 class="text-4xl font-bold mb-3">
            Mari Tumbuh Lebih Hijau Bersama FLOMART
        </h2>
        <p class="text-lg text-green-100 leading-relaxed max-w-4xl">
            Temukan produk tanaman terbaik, dukung penjual lokal, dan mulai perjalanan hijau Anda bersama kami.
        </p>
    </div>
</section>

</div>

<script>
function konfirmasiLogout(urlLogout) {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = urlLogout;
    }
}
</script>

<!-- FOOTER -->
<footer class="bg-green-700 text-white py-14 mt-10">
    <div class="max-w-7xl mx-auto px-10">
        <div class="grid grid-cols-4 gap-10">

            <!-- BRAND -->
            <div>
                <img src="../assets/img/contrasLogoFlomart.png" width="150" alt="Logo Footer">

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