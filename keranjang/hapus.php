<?php
include '../koneksi/koneksi.php';
session_start();

$id_user = $_SESSION['id_user'];
$id = (int) $_POST['id'];

mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = $id AND id_user = $id_user");

echo "ok";