<?php
include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID produk tidak valid.");
}

$query = "DELETE FROM produk WHERE id_produk = $id";
$delete = mysqli_query($conn, $query);

if ($delete) {
    header("Location: /FLOMART-ets/admin/produk/index.php");
    exit;
} else {
    die("Gagal menghapus produk.");
}
?>