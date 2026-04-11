<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

harusLogin();

$id = (int) $_GET['id'];

/* proses upload bukti */
if (isset($_POST['upload'])) {
    $file = $_FILES['bukti'];

    if ($file['error'] == 0) {
        $namaFile = time() . '_' . basename($file['name']);

        move_uploaded_file(
            $file['tmp_name'],
            "../uploads/bukti/" . $namaFile
        );

        mysqli_query($conn, "
            UPDATE pesanan
            SET bukti_pembayaran = '$namaFile'
            WHERE id_pesanan = $id
        ");

        header("Location: pembayaran.php?id=$id");
        exit;
    }
}

/* ambil data pesanan */
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

$bukti = $pesanan['bukti_pembayaran'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran</title>
<link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen p-6">

<a href="pesanan_saya.php" class="text-green-600 hover:underline">← Kembali</a>

<div class="bg-white rounded-xl shadow p-6 mt-4">

    <h2 class="text-xl font-bold mb-4">
        Pembayaran Pesanan #<?= $pesanan['id_pesanan']; ?>
    </h2>

    <p><b>Nama:</b> <?= $pesanan['nama']; ?></p>
    <p><b>No HP:</b> <?= $pesanan['no_hp']; ?></p>
    <p><b>Alamat:</b> <?= $pesanan['alamat_kirim']; ?></p>
    <p><b>Metode:</b> <?= $pesanan['metode_pembayaran']; ?></p>

    <hr class="my-4">

    <h3 class="font-semibold mb-3">Detail Produk</h3>

    <?php while ($d = mysqli_fetch_assoc($detail)): ?>
        <div class="flex justify-between border-b py-2 text-sm">
            <span><?= $d['nama_produk']; ?> (<?= $d['qty']; ?>x)</span>
            <span>Rp <?= number_format($d['subtotal']); ?></span>
        </div>
    <?php endwhile; ?>

    <div class="text-right font-bold text-green-600 mt-4">
        Total: Rp <?= number_format($pesanan['total_harga']); ?>
    </div>

    <hr class="my-4">

    <h3 class="font-semibold mb-3">Upload Bukti Pembayaran</h3>

    <?php if ($bukti): ?>
        <p class="text-green-600 mb-2">Bukti berhasil diupload</p>
        <a href="/FLOMART-ets/uploads/bukti/<?= $bukti; ?>" target="_blank">
            <img src="/FLOMART-ets/uploads/bukti/<?= $bukti; ?>"
                 class="w-64 rounded border cursor-pointer">
        </a>
    <?php else: ?>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <input 
                type="file" 
                name="bukti" 
                required
                class="border rounded px-3 py-2 w-full"
            >

            <button 
                type="submit" 
                name="upload"
                class="bg-blue-600 text-white px-4 py-2 rounded mt-3">
                Upload Bukti
            </button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>