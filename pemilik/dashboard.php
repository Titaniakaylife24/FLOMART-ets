<?php
include '../cek_login.php';
cekRole('owner');

include '../koneksi/koneksi.php';

$nama = $_SESSION['nama'] ?? 'Pemilik';
$role = $_SESSION['role'] ?? 'owner';

/* ambil data asli dari database */

// Total Produk
$qProduk = mysqli_query($conn, "SELECT COUNT(*) AS total_produk FROM produk");
$dProduk = $qProduk ? mysqli_fetch_assoc($qProduk) : [];
$totalProduk = $dProduk['total_produk'] ?? 0;

// Total Transaksi
$qTransaksi = mysqli_query($conn, "SELECT COUNT(*) AS total_transaksi FROM pesanan");
$dTransaksi = $qTransaksi ? mysqli_fetch_assoc($qTransaksi) : [];
$totalTransaksi = $dTransaksi['total_transaksi'] ?? 0;

// Total Pendapatan
$qPendapatan = mysqli_query($conn, "SELECT COALESCE(SUM(total_harga), 0) AS total_pendapatan FROM pesanan");
$dPendapatan = $qPendapatan ? mysqli_fetch_assoc($qPendapatan) : [];
$totalPendapatan = $dPendapatan['total_pendapatan'] ?? 0;

// Total Pembeli Unik
$qPembeli = mysqli_query($conn, "SELECT COUNT(DISTINCT id_user) AS total_pembeli FROM pesanan");
$dPembeli = $qPembeli ? mysqli_fetch_assoc($qPembeli) : [];
$totalPembeli = $dPembeli['total_pembeli'] ?? 0;

include 'dashboard_view.php';
?>