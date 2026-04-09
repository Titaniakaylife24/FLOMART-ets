<?php
include '../cek_login.php';
cekRole('pembeli');
include '../koneksi/koneksi.php';

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// ambil kategori
$queryKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

// ambil produk + kategori
$queryProduk = "SELECT produk.*, kategori.nama_kategori 
                FROM produk
                JOIN kategori ON produk.id_kategori = kategori.id_kategori
                ORDER BY produk.id_produk DESC";
$resultProduk = mysqli_query($conn, $queryProduk);

include 'dashboard_view.php';
?>