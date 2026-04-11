<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

harusLogin();

/* === HANDLE BATALKAN PESANAN === */
if (isset($_GET['batalkan'])) {

    $id = (int) $_GET['batalkan'];
    $id_user = $_SESSION['id_user'];

    $cek = mysqli_query($conn, "
        SELECT * FROM pesanan
        WHERE id_pesanan = $id
        AND id_user = $id_user
        AND status_pesanan = 'menunggu'
    ");

    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "
            UPDATE pesanan
            SET status_pesanan = 'dibatalkan'
            WHERE id_pesanan = $id
        ");
    }

    $detail = mysqli_query($conn, "
    SELECT * FROM detail_pesanan
    WHERE id_pesanan = $id
");

while ($d = mysqli_fetch_assoc($detail)) {
    mysqli_query($conn, "
        UPDATE produk
        SET stok = stok + {$d['qty']}
        WHERE id_produk = {$d['id_produk']}
    ");
}
    header("Location: pesanan_saya.php");
    exit;
}

/* ambil pesanan */
$id_user = $_SESSION['id_user'];

$query = "
SELECT * FROM pesanan
WHERE id_user = $id_user
ORDER BY tanggal_pesanan DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pesanan Saya</title>
<link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto p-6">

<!-- HEADER -->
<div class="bg-white p-5 rounded-xl shadow mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Pesanan Saya</h1>
    <a href="../user/dashboard.php" class="text-green-600 hover:underline">
        ← Kembali
    </a>
</div>

<!-- NOTIF -->
<?php if (isset($_GET['success'])): ?>
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    Pesanan berhasil dibuat!
</div>
<?php endif; ?>

<?php if (isset($_GET['upload'])): ?>
<div class="bg-blue-100 text-blue-700 p-3 rounded mb-4">
    Bukti pembayaran berhasil diupload!
</div>
<?php endif; ?>

<?php if (mysqli_num_rows($result) == 0): ?>

<div class="bg-white p-10 rounded-xl shadow text-center text-gray-500">
    Belum ada pesanan 😢
</div>

<?php else: ?>

<div class="space-y-4">

<?php while ($p = mysqli_fetch_assoc($result)):

$status = $p['status_pesanan'];
$warna = "bg-gray-200 text-gray-700";

if ($status == 'menunggu') $warna = "bg-yellow-100 text-yellow-700";
if ($status == 'diproses') $warna = "bg-blue-100 text-blue-700";
if ($status == 'dikirim') $warna = "bg-purple-100 text-purple-700";
if ($status == 'selesai') $warna = "bg-green-100 text-green-700";
if ($status == 'dibatalkan') $warna = "bg-red-100 text-red-700";

$adaBukti = !empty($p['bukti_pembayaran']);
?>

<!-- CARD -->
<div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-2">
        <div>
            <p class="font-semibold text-gray-800">
                Pesanan #<?= $p['id_pesanan']; ?>
            </p>
            <p class="text-sm text-gray-500">
                <?= date('d M Y, H:i', strtotime($p['tanggal_pesanan'])); ?>
            </p>
        </div>

        <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $warna ?>">
            <?= ucfirst($status); ?>
        </span>
    </div>

    <!-- DATA -->
    <p class="text-sm text-gray-700">
        <?= htmlspecialchars($p['nama_penerima'] ?? 'Tidak ada'); ?> 
        (<?= $p['no_hp'] ?? '-' ?>)
    </p>

    <p class="text-sm text-gray-500 mt-1">
        <?= htmlspecialchars($p['alamat_kirim']); ?>
    </p>

    <?php if (!empty($p['catatan'])): ?>
    <p class="text-sm text-yellow-700 bg-yellow-50 p-2 rounded mt-2">
        📝 <?= htmlspecialchars($p['catatan']); ?>
    </p>
    <?php endif; ?>

    <p class="text-sm text-gray-500 mt-2">
        Metode: <?= htmlspecialchars($p['metode_pembayaran']); ?>
    </p>

    <!-- TOTAL -->
    <div class="flex justify-between items-center border-t pt-3 mt-3">
        <span class="text-gray-600">Total Belanja</span>
        <span class="font-bold text-green-600">
            Rp <?= number_format($p['total_harga']); ?>
        </span>
    </div>

    <!-- ACTION -->
    <div class="mt-4 flex justify-between items-center">

        <!-- DETAIL -->
        <a href="detail_pesanan.php?id=<?= $p['id_pesanan']; ?>"
           class="text-blue-600 text-sm hover:underline">
            Detail
        </a>

        <!-- BUTTON -->
        <div class="flex gap-2">

        <?php if (
            $p['metode_pembayaran'] == 'Transfer' &&
            $status == 'menunggu'
        ): ?>

            <?php if (!$adaBukti): ?>
                <a href="upload_bukti.php?id=<?= $p['id_pesanan']; ?>"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                    Upload Bukti
                </a>
            <?php else: ?>
                <span class="text-sm text-gray-500 italic">
                    Menunggu Verifikasi
                </span>
            <?php endif; ?>

        <?php endif; ?>

        <!-- BATALKAN -->
        <?php if ($status == 'menunggu'): ?>
            <a href="pesanan_saya.php?batalkan=<?= $p['id_pesanan']; ?>"
               onclick="return confirm('Yakin ingin membatalkan pesanan ini?')"
               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                Batalkan
            </a>
        <?php endif; ?>

        </div>

    </div>

</div>

<?php endwhile; ?>

</div>

<?php endif; ?>

</div>

</body>
</html>