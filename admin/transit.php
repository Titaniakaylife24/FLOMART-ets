<?php
session_start();

$isLogin = isset($_SESSION['id_user']);
$role = $_SESSION['role'] ?? 'guest';
$nama = $_SESSION['nama'] ?? 'Guest';

if ($isLogin && $role === 'admin') {
    header("Location: /FLOMART-ets/admin/dashboard.php");
    exit;
}

$redirect = urlencode('/FLOMART-ets/admin/dashboard.php');
$loginUrl = "/FLOMART-ets/login/login.php?redirect=" . $redirect;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Jualan - FLOMART</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 font-sans">

<!-- HEADER -->
<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow z-50">
    <div class="flex items-center justify-between px-10 py-4">
        <img src="../assets/img/LogoFlomart.png" width="150">

        <div class="flex items-center gap-8">
            <nav class="flex items-center gap-6 text-gray-700 font-medium text-sm">
                <a href="#" class="hover:text-green-600">Chat</a>
                <a href="#" class="hover:text-green-600">Pesanan</a>
                <a href="#" class="hover:text-green-600">Notifikasi</a>

                <div class="w-6 h-6 rounded-full border-2 border-green-500 flex items-center justify-center text-green-600 text-xs">
                    G
                </div>
            </nav>

            <a href="/FLOMART-ets/login/login.php"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Login
            </a>
        </div>
    </div>

    <nav class="border-t px-10 py-3 flex justify-center gap-10 text-gray-500 font-medium">
        <a href="/FLOMART-ets/user/dashboard.php" class="hover:text-green-600">Beranda</a>
        <a href="#" class="hover:text-green-600">Toko</a>
        <a href="/FLOMART-ets/admin/transit.php" class="text-green-600 border-b-2 border-green-600 pb-1">Mulai Jualan</a>
        <a href="#" class="hover:text-green-600">Blog</a>
        <a href="/FLOMART-ets/user/tentang_kami.php" class="hover:text-green-600">Tentang Kami</a>
    </nav>
</header>

<!-- CONTENT -->
<div class="pt-32 px-10 max-w-7xl mx-auto">

    <section class="mb-6 mt-10">
        <h1 class="text-4xl font-bold">
            Selamat datang, <?= htmlspecialchars($nama); ?>!
        </h1>
    </section>

    <!-- BANNER TRANSIT ADMIN -->
    <section class="mb-20">
        <div class="rounded-2xl px-10 py-12 flex items-center justify-between bg-cover bg-center"
             style="background-image: url('../assets/img/BannerBg.png');">

            <div class="max-w-xl">
                <h1 class="text-4xl font-bold mb-6">
                    Kelola Toko <br>
                    dan Mulai Jualan <br>
                    dengan Mudah
                </h1>

                <p class="text-gray-500 mb-8 text-lg">
                    Masuk sebagai admin untuk menambahkan produk, mengatur stok, memantau pesanan, dan mengelola penjualan toko Anda di FLOMART.
                </p>

                <a href="<?= htmlspecialchars($loginUrl); ?>"
                   class="inline-block bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 font-semibold shadow-md transition">
                    Login
                </a>
            </div>

            <div class="relative">
                <img src="../assets/img/FotoLogin.png" width="300">

                <div class="absolute top-8 -left-8 bg-white rounded-xl shadow px-4 py-3 text-sm font-medium">
                    Dashboard Admin
                </div>

                <div class="absolute bottom-10 -right-8 bg-white rounded-xl shadow px-4 py-3 text-sm font-medium text-green-600">
                    Kelola Produk
                </div>
            </div>
        </div>
    </section>

</div>    
<!-- FOOTER -->
<footer class="w-full bg-green-700 text-white py-14 mt-10">
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
    
</div>

</body>
</html>