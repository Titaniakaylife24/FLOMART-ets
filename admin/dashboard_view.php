<?php
include __DIR__ . '/../cek_login.php';
include __DIR__ . '/../koneksi/koneksi.php';

cekRole('admin');

/* produk */
$query = "SELECT produk.*, kategori.nama_kategori
          FROM produk
          JOIN kategori ON produk.id_kategori = kategori.id_kategori
          ORDER BY produk.id_produk DESC";

$resultProduk = mysqli_query($conn, $query);

/* statistik */
$totalProduk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk"));
$totalPesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pesanan"));
$pesananBaru = mysqli_num_rows(mysqli_query($conn, "
SELECT * FROM pesanan WHERE status_pesanan = 'menunggu'
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">

<meta http-equiv="refresh" content="15">
</head>

<body class="bg-gray-100 min-h-screen">

<?php if (isset($_GET['hapus'])): ?>
<script>alert("Produk berhasil dihapus!");</script>
<?php endif; ?>

<!-- HEADER FIXED (LEBIH RINGKAS) -->
<div class="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur border-b z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Dashboard Admin
            </h1>
            <p class="text-sm text-gray-500">
                Kelola toko dan pesanan
            </p>
        </div>

        <button 
    onclick="if(confirm('Apakah Anda yakin ingin logout?')) window.location.href='/FLOMART-ets/login/logout.php';"
    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
    Logout
</button>

    </div>
</div>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-6 pt-28 pb-6 space-y-6">

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white border rounded-xl p-4 shadow-sm">
            <p class="text-gray-500 text-sm">Total Produk</p>
            <h2 class="text-2xl font-bold"><?= $totalProduk; ?></h2>
        </div>

        <div class="bg-white border rounded-xl p-4 shadow-sm">
            <p class="text-gray-500 text-sm">Total Pesanan</p>
            <h2 class="text-2xl font-bold"><?= $totalPesanan; ?></h2>
        </div>

        <div class="bg-white border rounded-xl p-4 shadow-sm">
            <p class="text-gray-500 text-sm">Pesanan Baru</p>
            <h2 class="text-2xl font-bold text-yellow-600">
                <?= $pesananBaru; ?>
            </h2>
        </div>

        <div class="bg-white border rounded-xl p-4 shadow-sm flex items-center">
            <a href="/FLOMART-ets/admin/pesanan/index.php"
               class="text-blue-600 font-semibold hover:underline">
                Lihat Pesanan →
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    <?php if ($pesananBaru > 0): ?>
    <div class="bg-yellow-100 text-yellow-700 p-4 rounded-xl flex justify-between items-center">
        <span>
            Ada <?= $pesananBaru; ?> pesanan baru!
        </span>
        <a href="/FLOMART-ets/admin/pesanan/index.php"
           class="font-semibold underline">
            Lihat sekarang
        </a>
    </div>
    <?php endif; ?>

    <!-- MENU -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="/FLOMART-ets/admin/produk/tambah.php"
           class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-5 shadow transition">
            <h2 class="text-lg font-bold">+ Tambah Produk</h2>
        </a>

        <a href="/FLOMART-ets/admin/kategori/index.php"
           class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-5 shadow transition">
            <h2 class="text-lg font-bold">Kelola Kategori</h2>
        </a>

        <a href="/FLOMART-ets/admin/pesanan/index.php"
           class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-5 shadow relative transition">

            <h2 class="text-lg font-bold">Kelola Pesanan</h2>

            <?php if ($pesananBaru > 0): ?>
            <span class="absolute top-2 right-3 bg-red-500 text-white text-xs px-2 rounded-full">
                <?= $pesananBaru; ?>
            </span>
            <?php endif; ?>

        </a>
    </div>

    <!-- TABEL PRODUK -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

        <div class="p-5 border-b">
            <h2 class="text-xl font-bold">
                Daftar Produk
            </h2>
        </div>

        <div class="max-h-[500px] overflow-y-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-100 sticky top-0">
                    <tr>
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Kategori</th>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Harga</th>
                        <th class="p-4 text-left">Stok</th>
                        <th class="p-4 text-left">Gambar</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($p = mysqli_fetch_assoc($resultProduk)): ?>
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-4"><?= $p['id_produk']; ?></td>
                    <td class="p-4"><?= $p['nama_kategori']; ?></td>
                    <td class="p-4 font-medium"><?= $p['nama_produk']; ?></td>
                    <td class="p-4">Rp <?= number_format($p['harga']); ?></td>
                    <td class="p-4"><?= $p['stok']; ?></td>

                    <td class="p-4">
                        <img src="/FLOMART-ets/uploads/produk/<?= $p['gambar']; ?>"
                             class="w-16 h-16 object-cover rounded-lg border"
                             onerror="this.src='/FLOMART-ets/assets/img/no-image.png'">
                    </td>

                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <a href="/FLOMART-ets/admin/produk/edit.php?id=<?= $p['id_produk']; ?>"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
                                Edit
                            </a>

                            <a href="/FLOMART-ets/admin/produk/hapus.php?id=<?= $p['id_produk']; ?>"
                               onclick="return confirm('Hapus produk?')"
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm">
                                Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>

            </table>
        </div>

    </div>

</div>

</body>
</html>