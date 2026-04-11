<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../cek_login.php';
cekRole('owner');

include '../koneksi/koneksi.php';

$nama = $_SESSION['nama'] ?? 'Pemilik';
$role = $_SESSION['role'] ?? 'owner';

$bulan = isset($_GET['bulan']) ? (int) $_GET['bulan'] : date('n');
$tahun = isset($_GET['tahun']) ? (int) $_GET['tahun'] : date('Y');

$totalItemTerjual = 0;
$totalPendapatanProduk = 0;
$produkNomorSatu = '-';

/* Ringkasan total item & pendapatan produk */
$qRingkasan = mysqli_query($conn, "
    SELECT 
        COALESCE(SUM(dp.qty), 0) AS total_item,
        COALESCE(SUM(dp.subtotal), 0) AS total_pendapatan
    FROM detail_pesanan dp
    INNER JOIN pesanan ps ON dp.id_pesanan = ps.id_pesanan
    WHERE MONTH(ps.tanggal_pesanan) = $bulan
      AND YEAR(ps.tanggal_pesanan) = $tahun
") or die('Query ringkasan error: ' . mysqli_error($conn));

if ($qRingkasan) {
    $ringkasan = mysqli_fetch_assoc($qRingkasan);
    $totalItemTerjual = $ringkasan['total_item'] ?? 0;
    $totalPendapatanProduk = $ringkasan['total_pendapatan'] ?? 0;
}

/* Produk nomor 1 */
$qTop1 = mysqli_query($conn, "
    SELECT 
        p.nama_produk,
        COALESCE(SUM(dp.qty), 0) AS total_terjual
    FROM detail_pesanan dp
    INNER JOIN produk p ON dp.id_produk = p.id_produk
    INNER JOIN pesanan ps ON dp.id_pesanan = ps.id_pesanan
    WHERE MONTH(ps.tanggal_pesanan) = $bulan
      AND YEAR(ps.tanggal_pesanan) = $tahun
    GROUP BY p.id_produk, p.nama_produk
    ORDER BY total_terjual DESC, p.nama_produk ASC
    LIMIT 1
") or die('Query top 1 error: ' . mysqli_error($conn));

if ($qTop1 && mysqli_num_rows($qTop1) > 0) {
    $top1 = mysqli_fetch_assoc($qTop1);
    $produkNomorSatu = $top1['nama_produk'];
}

/* Data tabel produk terlaris */
$queryProdukTerlaris = mysqli_query($conn, "
    SELECT 
        p.id_produk,
        p.nama_produk,
        p.gambar,
        p.harga,
        p.stok,
        COALESCE(SUM(dp.qty), 0) AS total_terjual,
        COALESCE(SUM(dp.subtotal), 0) AS total_pendapatan
    FROM detail_pesanan dp
    INNER JOIN produk p ON dp.id_produk = p.id_produk
    INNER JOIN pesanan ps ON dp.id_pesanan = ps.id_pesanan
    WHERE MONTH(ps.tanggal_pesanan) = $bulan
      AND YEAR(ps.tanggal_pesanan) = $tahun
    GROUP BY p.id_produk, p.nama_produk, p.gambar, p.harga, p.stok
    ORDER BY total_terjual DESC, total_pendapatan DESC, p.nama_produk ASC
") or die('Query tabel error: ' . mysqli_error($conn));

include __DIR__ . '/produk_terlaris__view.php';
?>