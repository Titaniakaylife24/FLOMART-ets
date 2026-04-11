<?php
include '../../cek_login.php';
include '../../koneksi/koneksi.php';

cekRole('admin');

$id = (int) $_GET['id'];

/* ambil pesanan */
$pesanan = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT pesanan.*, users.nama, users.no_hp
FROM pesanan
JOIN users ON pesanan.id_user = users.id_user
WHERE id_pesanan = $id
"));

/* detail produk */
$detail = mysqli_query($conn, "
SELECT detail_pesanan.*, produk.nama_produk
FROM detail_pesanan
JOIN produk ON detail_pesanan.id_produk = produk.id_produk
WHERE id_pesanan = $id
");

/* bukti pembayaran */
$bukti = $pesanan['bukti_pembayaran'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pesanan</title>
<link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen p-6">

<a href="index.php" class="text-green-600 hover:underline">← Kembali</a>

<div class="bg-white rounded-xl shadow p-6 mt-4">

<!-- HEADER -->
<h2 class="text-xl font-bold mb-4">
    Pesanan #<?= $pesanan['id_pesanan']; ?>
</h2>

<!-- DATA USER -->
<p><b>Nama:</b> <?= htmlspecialchars($pesanan['nama']); ?></p>
<p><b>No HP:</b> <?= htmlspecialchars($pesanan['no_hp']); ?></p>
<p><b>Alamat:</b> <?= htmlspecialchars($pesanan['alamat_kirim']); ?></p>
<p><b>Metode:</b> <?= htmlspecialchars($pesanan['metode_pembayaran']); ?></p>
<p><b>Status:</b> <?= ucfirst($pesanan['status_pesanan']); ?></p>

<hr class="my-4">

<!-- PRODUK -->
<h3 class="font-semibold mb-3">Produk</h3>

<?php while ($d = mysqli_fetch_assoc($detail)): ?>
<div class="flex justify-between border-b py-2 text-sm">
    <span><?= htmlspecialchars($d['nama_produk']); ?> (<?= $d['qty']; ?>x)</span>
    <span>Rp <?= number_format($d['subtotal']); ?></span>
</div>
<?php endwhile; ?>

<div class="text-right font-bold text-green-600 mt-4">
    Total: Rp <?= number_format($pesanan['total_harga']); ?>
</div>

<hr class="my-4">

<!-- BUKTI PEMBAYARAN -->
<h3 class="font-semibold mb-2">Bukti Pembayaran</h3>

<?php if ($bukti): ?>
    <a href="/FLOMART-ets/uploads/bukti/<?= $bukti; ?>" target="_blank">
        <img src="/FLOMART-ets/uploads/bukti/<?= $bukti; ?>"
             class="w-64 rounded border hover:opacity-80 cursor-pointer">
    </a>
<?php else: ?>
    <p class="text-gray-500">Belum upload bukti</p>
<?php endif; ?>

<hr class="my-4">

<!-- TOMBOL ADMIN -->
<?php if ($pesanan['status_pesanan'] == 'menunggu'): ?>

<div class="flex gap-3">

    <a href="update_status.php?id=<?= $id; ?>&aksi=terima"
       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Terima
    </a>

    <a href="update_status.php?id=<?= $id; ?>&aksi=tolak"
       class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
       onclick="return confirm('Yakin ingin menolak pesanan ini?')">
        Tolak
    </a>

</div>

<?php endif; ?>

</div>

</body>
</html>