<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    $redirect = urlencode($_SERVER['REQUEST_URI']);
    header("Location: ../login/login.php?redirect=$redirect");
    exit;
}

if ($_SESSION['role'] !== 'pembeli') {
    header("Location: ../login/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_produk = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$qty = isset($_GET['qty']) ? (int) $_GET['qty'] : 1;

// validasi qty
if ($qty < 1) {
    $qty = 1;
}

if ($id_produk <= 0) {
    header("Location: ../index.php");
    exit;
}

// cek produk valid
$queryProduk = "SELECT * FROM produk WHERE id_produk = $id_produk AND stok > 0";
$resultProduk = mysqli_query($conn, $queryProduk);

if (mysqli_num_rows($resultProduk) === 0) {
    header("Location: ../index.php");
    exit;
}

// cek apakah produk sudah ada di keranjang user
$queryCek = "SELECT * FROM keranjang 
             WHERE id_user = $id_user 
             AND id_produk = $id_produk";

$resultCek = mysqli_query($conn, $queryCek);

if (mysqli_num_rows($resultCek) > 0) {

    $data = mysqli_fetch_assoc($resultCek);

    // 🔥 update pakai qty dari modal
    $jumlahBaru = $data['jumlah'] + $qty;

    $update = "UPDATE keranjang 
               SET jumlah = $jumlahBaru 
               WHERE id_keranjang = " . $data['id_keranjang'];

    mysqli_query($conn, $update);

} else {

    // 🔥 insert pakai qty dari modal
    $insert = "INSERT INTO keranjang (id_user, id_produk, jumlah) 
               VALUES ($id_user, $id_produk, $qty)";

    mysqli_query($conn, $insert);
}

// kembali ke halaman sebelumnya (lebih enak UX)
header("Location: ../user/dashboard.php");
exit;
?>