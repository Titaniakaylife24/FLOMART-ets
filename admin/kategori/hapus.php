<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID kategori tidak valid.");
}

// cek apakah kategori masih dipakai produk
$queryCekProduk = "SELECT COUNT(*) AS total FROM produk WHERE id_kategori = $id";
$resultCekProduk = mysqli_query($conn, $queryCekProduk);

if (!$resultCekProduk) {
    die("Gagal mengecek relasi produk: " . mysqli_error($conn));
}

$dataCek = mysqli_fetch_assoc($resultCekProduk);

if ($dataCek['total'] > 0) {
    die("Kategori tidak bisa dihapus karena masih dipakai oleh produk.");
}

// hapus kategori
$queryDelete = "DELETE FROM kategori WHERE id_kategori = $id";
$delete = mysqli_query($conn, $queryDelete);

if ($delete) {
    header("Location: index.php");
    exit;
} else {
    die("Gagal menghapus kategori: " . mysqli_error($conn));
}
?>