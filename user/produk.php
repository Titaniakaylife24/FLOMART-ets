<?php
include '../cek_login.php';
cekRole('pembeli');
include '../koneksi/koneksi.php';

$query = "SELECT produk.*, kategori.nama_kategori 
          FROM produk
          JOIN kategori ON produk.id_kategori = kategori.id_kategori
          ORDER BY produk.id_produk DESC";

$result = mysqli_query($conn, $query);

include 'produk_view.php';
?>