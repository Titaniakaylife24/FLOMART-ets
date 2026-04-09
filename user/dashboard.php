<?php
include '../cek_login.php';
cekRole('pembeli');
include '../koneksi/koneksi.php';

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// ambil kategori
$queryKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

// ambil kategori yang dipilih dari URL
$id_kategori = isset($_GET['kategori']) ? (int) $_GET['kategori'] : 0;

// query produk
if ($id_kategori > 0) {
    $queryProduk = "SELECT produk.*, kategori.nama_kategori 
                    FROM produk
                    JOIN kategori ON produk.id_kategori = kategori.id_kategori
                    WHERE produk.id_kategori = $id_kategori
                    ORDER BY produk.id_produk DESC";
} else {
    $queryProduk = "SELECT produk.*, kategori.nama_kategori 
                    FROM produk
                    JOIN kategori ON produk.id_kategori = kategori.id_kategori
                    ORDER BY produk.id_produk DESC";
}
$resultProduk = mysqli_query($conn, $queryProduk);

include 'dashboard_view.php';
?>