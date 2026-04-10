<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

cekRole('admin');

$nama = $_SESSION['nama'] ?? 'Admin';

// ambil semua produk + nama kategori
$queryProduk = "SELECT produk.*, kategori.nama_kategori
                FROM produk
                JOIN kategori ON produk.id_kategori = kategori.id_kategori
                ORDER BY produk.id_produk DESC";

$resultProduk = mysqli_query($conn, $queryProduk);

include 'dashboard_view.php';
?>