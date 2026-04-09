<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] === 'owner') {
        header("Location: pemilik/dashboard.php");
        exit;
    }
}

$nama = $_SESSION['nama'] ?? 'Guest';
$role = $_SESSION['role'] ?? 'guest';

include 'koneksi/koneksi.php';

$queryKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

$id_kategori = isset($_GET['kategori']) ? (int) $_GET['kategori'] : 0;

$queryRekomendasi = "SELECT produk.*, kategori.nama_kategori
                     FROM produk
                     JOIN kategori ON produk.id_kategori = kategori.id_kategori
                     WHERE produk.stok > 0
                     ORDER BY RAND()
                     LIMIT 4";
$resultRekomendasi = mysqli_query($conn, $queryRekomendasi);

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

include 'index_view.php';
?>