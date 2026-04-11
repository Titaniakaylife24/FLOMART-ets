<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

harusLogin();

$id = (int) $_GET['id'];
$id_user = $_SESSION['id_user'];

/* ambil pesanan */
$pesanan = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM pesanan 
WHERE id_pesanan = $id AND id_user = $id_user
"));

if (!$pesanan) {
    die("Pesanan tidak ditemukan");
}

/* ambil detail produk */
$detail = mysqli_query($conn, "
SELECT detail_pesanan.*, 
       produk.nama_produk,
       produk.gambar
FROM detail_pesanan
JOIN produk ON detail_pesanan.id_produk = produk.id_produk
WHERE detail_pesanan.id_pesanan = $id
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Detail Pesanan</title>
<link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen p-6">

<a href="pesanan_saya.php" class="text-green-600 hover:underline">
← Kembali
</a>

<div class="bg-white rounded-xl shadow p-6 mt-4">

<h2 class="text-xl font-bold mb-4">
Pesanan #<?= $pesanan['id_pesanan']; ?>
</h2>

<p><b>Nama:</b> <?= htmlspecialchars($pesanan['nama_penerima']); ?></p>
<p><b>No HP:</b> <?= htmlspecialchars($pesanan['no_hp']); ?></p>
<p><b>Alamat:</b> <?= htmlspecialchars($pesanan['alamat_kirim']); ?></p>

<hr class="my-4">

<h3 class="font-semibold mb-3">Daftar Produk</h3>

<?php while ($d = mysqli_fetch_assoc($detail)): ?>

<div class="flex items-center justify-between border-b py-3 gap-4">

    <!-- GAMBAR -->
    <img src="/FLOMART-ets/uploads/produk/<?= $d['gambar']; ?>"
         class="w-16 h-16 object-cover rounded border"
         onerror="this.src='/FLOMART-ets/assets/img/no-image.png'">

    <!-- INFO -->
    <div class="flex-1">
        <p class="font-semibold">
            <?= htmlspecialchars($d['nama_produk']); ?>
        </p>
        <p class="text-sm text-gray-500">
            <?= $d['qty']; ?> x Rp <?= number_format($d['harga']); ?>
        </p>
    </div>

    <!-- TOTAL -->
    <div class="font-semibold text-green-600">
        Rp <?= number_format($d['subtotal']); ?>
    </div>

</div>

<?php endwhile; ?>

<div class="text-right font-bold text-green-600 mt-4">
Total: Rp <?= number_format($pesanan['total_harga']); ?>
</div>

</div>

</body>
</html>