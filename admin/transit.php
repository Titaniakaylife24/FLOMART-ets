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

    <nav class="border-t px-10 py-3 flex justify-center gap-10 text-gray-700 font-medium">
        <a href="/FLOMART-ets/user/dashboard.php" class="hover:text-green-600">Beranda</a>
        <a href="#" class="hover:text-green-600">Toko</a>
        <a href="/FLOMART-ets/admin/transit.php" class="text-green-600 border-b-2 border-green-600 pb-1">Mulai Jualan</a>
        <a href="#" class="hover:text-green-600">Blog</a>
        <a href="#" class="hover:text-green-600">Tentang Kami</a>
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
    <section class="mb-12">
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

</body>
</html>