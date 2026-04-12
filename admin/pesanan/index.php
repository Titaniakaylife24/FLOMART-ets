<?php
include '../../cek_login.php';
include '../../koneksi/koneksi.php';

cekRole('admin');

$query = "
SELECT * FROM pesanan
ORDER BY tanggal_pesanan DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pesanan</title>
<link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="flex justify-between items-center mb-6">

<h1 class="text-2xl font-bold">Data Pesanan</h1>

<a href="/FLOMART-ets/admin/dashboard.php"
   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
   ← Dashboard
</a>

</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full text-sm">

<thead  class="bg-green-100 text-green-800">
<tr>
<th class="p-3">ID</th>
<th class="p-3">Pembeli</th>
<th class="p-3">Tanggal</th>
<th class="p-3">Total</th>
<th class="p-3">Metode</th>
<th class="p-3">Status</th>
<th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>

<?php while ($p = mysqli_fetch_assoc($result)): ?>

<?php
$status = $p['status_pesanan'];

$warna = "bg-gray-200 text-gray-700";
if ($status == 'menunggu') $warna = "bg-yellow-100 text-yellow-700";
if ($status == 'diproses') $warna = "bg-blue-100 text-blue-700";
if ($status == 'dikirim') $warna = "bg-purple-100 text-purple-700";
if ($status == 'selesai') $warna = "bg-green-100 text-green-700";
if ($status == 'dibatalkan') $warna = "bg-red-100 text-red-700";
?>

<tr class="border-t">
<td class="p-3"><?= $p['id_pesanan']; ?></td>
<td class="p-3">
    <?= htmlspecialchars($p['nama_penerima']); ?><br>
    <span class="text-xs text-gray-500">
        <?= $p['no_hp']; ?>
    </span>
</td>
<td class="p-3"><?= $p['tanggal_pesanan']; ?></td>

<td class="p-3 text-green-600 font-semibold">
Rp <?= number_format($p['total_harga']); ?>
</td>

<td class="p-3"><?= $p['metode_pembayaran']; ?></td>

<!-- KOLOM CATATAN -->
<td class="p-3 text-gray-600">
<?= htmlspecialchars($p['catatan']); ?>
</td>

<td class="p-3">
<span class="px-3 py-1 rounded-full text-xs font-semibold <?= $warna ?>">
<?= ucfirst($status); ?>
</span>
</td>

<td class="p-3">
<a href="detail.php?id=<?= $p['id_pesanan']; ?>"
   class="text-blue-600 hover:underline">
   Detail
</a>
</td>
</tr>

<?php endwhile; ?>

</tbody>
</table>

</div>

</body>
</html>