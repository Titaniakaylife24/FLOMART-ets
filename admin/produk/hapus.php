<?php
include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

// Ambil ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID produk tidak valid.");
}

// (Optional) Ambil gambar dulu biar bisa dihapus dari folder
$get = mysqli_query($conn, "SELECT gambar FROM produk WHERE id_produk = $id");
$data = mysqli_fetch_assoc($get);

if ($data && !empty($data['gambar'])) {
    $path = __DIR__ . '/../../uploads/produk/' . $data['gambar'];
    if (file_exists($path)) {
        unlink($path); // hapus file gambar
    }
}

// Hapus dari database
$query = "DELETE FROM produk WHERE id_produk = $id";
$delete = mysqli_query($conn, $query);

if ($delete) {
    header("Location: /FLOMART-ets/admin/dashboard_view.php?hapus=success");
    exit;
} else {
    die("Gagal menghapus produk: " . mysqli_error($conn));
}
?>