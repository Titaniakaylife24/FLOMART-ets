<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Terlaris - FLOMART</title>
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 font-sans">

<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow z-50">
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

    <div class="px-10">
        <nav class="border-t-2 border-gray-200 py-3 flex justify-center gap-10 text-gray-700 font-medium">
            <a href="/FLOMART-ets/pemilik/dashboard.php" class="hover:text-green-600">
                Dashboard
            </a>
            <a href="/FLOMART-ets/pemilik/laporan_penjualan.php" class="hover:text-green-600">
                Laporan Penjualan
            </a>
            <a href="/FLOMART-ets/pemilik/produk_terlaris.php"
               class="text-green-600 border-b-2 border-green-600 pb-1">
                Produk Terlaris
            </a>
        </nav>
    </div>
</header>

<div class="pt-32 px-10 max-w-7xl mx-auto">

    <section class="mb-8 mt-10">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">
            Produk Terlaris
        </h1>
        <p class="text-gray-500">
            Pantau performa produk berdasarkan jumlah penjualan pada periode yang dipilih.
        </p>
    </section>

    <section class="mb-8">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <form method="GET" class="flex flex-wrap items-end gap-6">

                <div class="flex items-center gap-4">
                    <label class="text-2xl font-bold text-gray-700">Bulan</label>
                    <select name="bulan"
                        class="border border-gray-300 rounded-xl px-3 py-2 min-w-[70px] focus:ring-2 focus:ring-green-500">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i; ?>" <?= ($bulan == $i) ? 'selected' : ''; ?>>
                                <?= $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="flex items-center gap-4">
                    <label class="text-2xl font-bold text-gray-700">Tahun</label>
                    <select name="tahun"
                        class="border border-gray-300 rounded-xl px-4 py-2 min-w-[120px] focus:ring-2 focus:ring-green-500">
                        <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                            <option value="<?= $y; ?>" <?= ($tahun == $y) ? 'selected' : ''; ?>>
                                <?= $y; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-700 shadow-sm">
                        Tampilkan
                    </button>
                </div>

            </form>
        </div>
    </section>

    <section class="mb-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-md p-6 min-h-[170px] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-base text-gray-400 mb-2">Total Item Terjual</p>
                        <h3 class="text-4xl font-bold text-gray-900"><?= number_format($totalItemTerjual); ?></h3>
                    </div>
                    <div class="text-4xl">📦</div>
                </div>
                <p class="text-base text-green-600 font-medium mt-6">Akumulasi penjualan produk</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 min-h-[170px] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-base text-gray-400 mb-2">Pendapatan Produk</p>
                        <h3 class="text-3xl font-bold text-gray-900">
                            Rp <?= number_format($totalPendapatanProduk, 0, ',', '.'); ?>
                        </h3>
                    </div>
                    <div class="text-4xl">💰</div>
                </div>
                <p class="text-base text-green-600 font-medium mt-6">Dari produk terjual</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 min-h-[170px] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-base text-gray-400 mb-2">Produk Peringkat #1</p>
                        <h3 class="text-2xl font-bold text-gray-900 leading-snug">
                            <?= htmlspecialchars($produkNomorSatu); ?>
                        </h3>
                    </div>
                    <div class="text-4xl">🏆</div>
                </div>
                <p class="text-base text-green-600 font-medium mt-6">Terlaris periode ini</p>
            </div>
        </div>
    </section>

    <section class="mb-15">
        <div class="bg-white rounded-2xl shadow-md p-6 overflow-x-auto">
            <div class="mb-5">
                <h2 class="text-2xl font-bold mb-2">Daftar Produk Terlaris</h2>
                <p class="text-gray-500">Data produk berdasarkan total item terjual pada bulan dan tahun yang dipilih.</p>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-3 px-3">Ranking</th>
                        <th class="py-3 px-3">ID Produk</th>
                        <th class="py-3 px-3">Nama Produk</th>
                        <th class="py-3 px-3">Harga</th>
                        <th class="py-3 px-3">Stok</th>
                        <th class="py-3 px-3">Total Terjual</th>
                        <th class="py-3 px-3">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($queryProdukTerlaris && mysqli_num_rows($queryProdukTerlaris) > 0): ?>
                        <?php $ranking = 1; ?>
                        <?php while ($produk = mysqli_fetch_assoc($queryProdukTerlaris)): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-3"><?= $ranking++; ?></td>
                                <td class="py-3 px-3"><?= $produk['id_produk']; ?></td>
                                <td class="py-3 px-3"><?= htmlspecialchars($produk['nama_produk']); ?></td>
                                <td class="py-3 px-3">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></td>
                                <td class="py-3 px-3"><?= number_format($produk['stok']); ?></td>
                                <td class="py-3 px-3"><?= number_format($produk['total_terjual']); ?></td>
                                <td class="py-3 px-3">Rp <?= number_format($produk['total_pendapatan'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-6 px-3 text-center text-gray-500">
                                Belum ada data produk terlaris pada periode ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</div>

<div class="h-20"></div>
<div class="mt-10"></div>

<footer class="bg-green-700 text-white py-14 mt-24">
    <div class="max-w-7xl mx-auto px-10">
        <div class="max-w-7xl mx-auto px-10">
            <div class="grid grid-cols-4 gap-10">

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

                <div>
                    <h3 class="font-semibold mb-4">Layanan</h3>
                    <ul class="space-y-2 text-sm">
                        <li>Belanja Tanaman</li>
                        <li>Bibit & Media Tanaman</li>
                        <li>Filter Kecocokan Tanaman</li>
                        <li>Start Sell (jual tanaman)</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-sm">
                        <li>Cara Belanja</li>
                        <li>Cara Menjual Tanaman</li>
                        <li>Pengiriman & Perawatan</li>
                        <li>Kebijakan Pengembalian</li>
                    </ul>
                </div>

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