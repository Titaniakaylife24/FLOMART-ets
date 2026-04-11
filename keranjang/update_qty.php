<?php
include '../koneksi/koneksi.php';
session_start();

$id_user = $_SESSION['id_user'];
$id_keranjang = (int) $_POST['id'];
$aksi = $_POST['aksi'];

$query = "SELECT keranjang.jumlah, produk.stok 
FROM keranjang 
JOIN produk ON keranjang.id_produk = produk.id_produk
WHERE id_keranjang = $id_keranjang AND id_user = $id_user";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$jumlah = $data['jumlah'];
$stok = $data['stok'];

if ($aksi == 'tambah') {
    if ($jumlah < $stok) $jumlah++;
} else {
    if ($jumlah > 1) $jumlah--;
}

mysqli_query($conn, "UPDATE keranjang SET jumlah = $jumlah WHERE id_keranjang = $id_keranjang");

echo json_encode(["jumlah" => $jumlah]);