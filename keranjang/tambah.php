<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

harusLogin();

if ($_SESSION['role'] !== 'pembeli') {
    header("Location: ../login/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_produk = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id_produk <= 0) {
    header("Location: ../index.php");
    exit;
}

$queryProduk = "SELECT * FROM produk WHERE id_produk = $id_produk AND stok > 0";
$resultProduk = mysqli_query($conn, $queryProduk);

if (mysqli_num_rows($resultProduk) === 0) {
    header("Location: ../index.php");
    exit;
}

$queryCek = "SELECT * FROM keranjang WHERE id_user = $id_user AND id_produk = $id_produk";
$resultCek = mysqli_query($conn, $queryCek);

if (mysqli_num_rows($resultCek) > 0) {
    $data = mysqli_fetch_assoc($resultCek);
    $jumlahBaru = $data['jumlah'] + 1;

    $update = "UPDATE keranjang SET jumlah = $jumlahBaru WHERE id_keranjang = " . $data['id_keranjang'];
    mysqli_query($conn, $update);
} else {
    $insert = "INSERT INTO keranjang (id_user, id_produk, jumlah) VALUES ($id_user, $id_produk, 1)";
    mysqli_query($conn, $insert);
}

header("Location: ../index.php");
exit;
?>