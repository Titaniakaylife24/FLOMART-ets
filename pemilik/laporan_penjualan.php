<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';
cekRole('owner');

$nama = $_SESSION['nama'] ?? 'Owner';
$role = $_SESSION['role'] ?? 'owner';

$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('m');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');

/*
|--------------------------------------------------------------------------
| RINGKASAN UTAMA
|--------------------------------------------------------------------------
*/
$queryRingkasan = mysqli_query($conn, "
    SELECT 
        COUNT(*) AS total_transaksi,
        COALESCE(SUM(total_harga), 0) AS total_pendapatan
    FROM pesanan
    WHERE MONTH(tanggal_pesanan) = $bulan
      AND YEAR(tanggal_pesanan) = $tahun
");

if (!$queryRingkasan) {
    die('Error queryRingkasan: ' . mysqli_error($conn));
}

$ringkasan = mysqli_fetch_assoc($queryRingkasan);
$totalTransaksi = $ringkasan['total_transaksi'] ?? 0;
$totalPendapatan = $ringkasan['total_pendapatan'] ?? 0;

/*
|--------------------------------------------------------------------------
| TOTAL ITEM TERJUAL
|--------------------------------------------------------------------------
*/
$queryItem = mysqli_query($conn, "
    SELECT COALESCE(SUM(dp.qty), 0) AS total_item
    FROM detail_pesanan dp
    JOIN pesanan p ON dp.id_pesanan = p.id_pesanan
    WHERE MONTH(p.tanggal_pesanan) = $bulan
      AND YEAR(p.tanggal_pesanan) = $tahun
");

if (!$queryItem) {
    die('Error queryItem: ' . mysqli_error($conn));
}

$dataItem = mysqli_fetch_assoc($queryItem);
$totalItemTerjual = $dataItem['total_item'] ?? 0;

/*
|--------------------------------------------------------------------------
| TOTAL PEMBELI UNIK
|--------------------------------------------------------------------------
*/
$queryPembeli = mysqli_query($conn, "
    SELECT COUNT(DISTINCT id_user) AS total_pembeli
    FROM pesanan
    WHERE MONTH(tanggal_pesanan) = $bulan
      AND YEAR(tanggal_pesanan) = $tahun
");

if (!$queryPembeli) {
    die('Error queryPembeli: ' . mysqli_error($conn));
}

$dataPembeli = mysqli_fetch_assoc($queryPembeli);
$totalPembeli = $dataPembeli['total_pembeli'] ?? 0;

/*
|--------------------------------------------------------------------------
| DATA TABEL LAPORAN
|--------------------------------------------------------------------------
*/
$queryLaporan = mysqli_query($conn, "
    SELECT 
        p.id_pesanan,
        p.tanggal_pesanan,
        p.total_harga,
        p.status_pesanan,
        u.nama AS nama_pembeli
    FROM pesanan p
    JOIN users u ON p.id_user = u.id_user
    WHERE MONTH(p.tanggal_pesanan) = $bulan
      AND YEAR(p.tanggal_pesanan) = $tahun
    ORDER BY p.tanggal_pesanan DESC
");

if (!$queryLaporan) {
    die('Error queryLaporan: ' . mysqli_error($conn));
}

/*
|--------------------------------------------------------------------------
| DATA PENJUALAN PER BULAN
|--------------------------------------------------------------------------
*/
$queryBulanan = mysqli_query($conn, "
    SELECT 
        MONTH(tanggal_pesanan) AS bulan,
        COUNT(*) AS total_transaksi,
        COALESCE(SUM(total_harga), 0) AS total_pendapatan
    FROM pesanan
    WHERE YEAR(tanggal_pesanan) = $tahun
    GROUP BY MONTH(tanggal_pesanan)
    ORDER BY MONTH(tanggal_pesanan)
");

if (!$queryBulanan) {
    die('Error queryBulanan: ' . mysqli_error($conn));
}

$penjualanBulanan = [];
while ($row = mysqli_fetch_assoc($queryBulanan)) {
    $penjualanBulanan[] = $row;
}

include 'laporan_penjualan_view.php';
?>