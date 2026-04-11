<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik - FLOMART</title>
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 font-sans">

<!-- HEADER -->
<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow z-50">

    <!-- TOP BAR -->
    <div class="flex items-center justify-between px-10 py-4">
        <img src="../assets/img/LogoFlomart.png" alt="Logo FLOMART" width="150">

        <div class="flex items-center gap-4">
            <div class="hidden md:block text-right">
            </div>

            <button onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')"
                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                Logout
            </button>
        </div>
    </div>

    <!-- NAVBAR -->
    <div class="px-10">
        <nav class="border-t-2 border-gray-200 py-3 flex justify-center gap-10 text-gray-700 font-medium">
            <a href="/FLOMART-ets/pemilik/dashboard.php"
               class="text-green-600 border-b-2 border-green-600 pb-1">
                Dashboard
            </a>
            <a href="/FLOMART-ets/pemilik/laporan_penjualan.php" class="hover:text-green-600">
                Laporan Penjualan
            </a>
            <a href="/FLOMART-ets/pemilik/produk_terlaris.php" class="hover:text-green-600">
                Produk Terlaris
            </a>
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
        <p class="text-gray-500 mt-3">
            Kelola performa bisnis FLOMART dari satu dashboard yang ringkas dan terarah.
        </p>
    </section>

    <!-- BANNER / HERO -->
    <section class="mb-12">
        <div class="rounded-2xl px-10 py-12 flex items-center justify-between bg-cover bg-center"
             style="background-image: url('../assets/img/BannerBg.png');">

            <div class="max-w-2xl">
                <span class="inline-block bg-white/80 text-green-700 text-sm font-semibold px-4 py-2 rounded-full mb-5 shadow-sm">
                    Owner Dashboard
                </span>

                <h1 class="text-4xl font-bold mb-6 leading-tight">
                    Pantau Penjualan <br>
                    dan Produk Terlaris <br>
                    dengan Lebih Mudah
                </h1>

                <p class="text-gray-500 mb-6 text-lg leading-8">
                    Dashboard ini membantu owner FLOMART memantau kondisi bisnis,
                    melihat laporan penjualan, dan mengevaluasi performa produk
                    secara cepat dan rapi.
                </p>

                <div class="flex gap-6">
                    <a href="/FLOMART-ets/pemilik/laporan_penjualan.php"
                       class="bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition shadow">
                        Lihat Laporan
                    </a>

                    <a href="/FLOMART-ets/pemilik/produk_terlaris.php"
                       class="bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition shadow">
                        Produk Terlaris
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex flex-col gap-4 min-w-[260px]">
                <div class="bg-white/85 rounded-2xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500 mb-1">Role</p>
                    <p class="text-xl font-bold text-green-700"><?= htmlspecialchars($role); ?></p>
                </div>

                <div class="bg-white/85 rounded-2xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    <p class="text-xl font-bold text-green-700">Aktif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- RINGKASAN DASHBOARD -->
    <section class="mb-20">
        <div class="mb-8">
            <h2 class="text-3xl font-bold mb-3">Ringkasan Dashboard</h2>
            <p class="text-gray-500 text-lg">
                Gambaran singkat performa bisnis FLOMART saat ini.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition min-h-[180px] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-base text-gray-400 mb-2">Total Produk</p>
                        <h3 class="text-4xl font-bold text-gray-900">
                            <?= number_format($totalProduk); ?>
                        </h3>
                    </div>
                    <div class="text-4xl">🌱</div>
                </div>
                <p class="text-base text-green-600 font-medium mt-6">Inventaris aktif</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition min-h-[180px] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-base text-gray-400 mb-2">Total Transaksi</p>
                        <h3 class="text-4xl font-bold text-gray-900">
                            <?= number_format($totalTransaksi); ?>
                        </h3>
                    </div>
                    <div class="text-4xl">🛒</div>
                </div>
                <p class="text-base text-green-600 font-medium mt-6">Penjualan tercatat</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition min-h-[180px] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-base text-gray-400 mb-2">Total Pendapatan</p>
                        <h3 class="text-3xl font-bold text-gray-900 leading-tight">
                            Rp <?= number_format($totalPendapatan, 0, ',', '.'); ?>
                        </h3>
                    </div>
                    <div class="text-4xl">💰</div>
                </div>
                <p class="text-base text-green-600 font-medium mt-6">Akumulasi sementara</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition min-h-[180px] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-base text-gray-400 mb-2">Total Pembeli</p>
                        <h3 class="text-4xl font-bold text-gray-900">
                            <?= number_format($totalPembeli); ?>
                        </h3>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
                <p class="text-base text-green-600 font-medium mt-6">Pengguna aktif</p>
            </div>
        </div>
    </section>

</div>

<!-- JARAK -->
<div class="mt-10"></div>

<footer class="bg-green-700 text-white py-14 mt-24">

    <div class="max-w-7xl mx-auto px-10">

        <!-- BOX FOOTER (warna hijau TIDAK full layar) -->
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
function konfirmasiLogout(urlLogout) {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = urlLogout;
    }
}
</script>

</body>
</html>