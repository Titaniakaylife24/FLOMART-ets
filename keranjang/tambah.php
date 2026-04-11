<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

// ek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login/login.php");
    exit;
}

// hanya pembeli
if ($_SESSION['role'] !== 'pembeli') {
    header("Location: ../login/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// pakai POST (lebih aman)
$id_produk = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 1;

// validasi qty
if ($qty < 1) {
    $qty = 1;
}

if ($id_produk <= 0) {
    header("Location: ../user/dashboard.php");
    exit;
}

// ambil produk + stok
$stmt = $conn->prepare("SELECT stok FROM produk WHERE id_produk = ?");
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../user/dashboard.php");
    exit;
}

$produk = $result->fetch_assoc();
$stok = (int)$produk['stok'];

// kalau qty melebihi stok
if ($qty > $stok) {
    $qty = $stok;
}

// cek keranjang
$stmt = $conn->prepare("SELECT id_keranjang, jumlah FROM keranjang WHERE id_user = ? AND id_produk = ?");
$stmt->bind_param("ii", $id_user, $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $data = $result->fetch_assoc();
    $jumlahBaru = $data['jumlah'] + $qty;

    //  jangan lebih dari stok
    if ($jumlahBaru > $stok) {
        $jumlahBaru = $stok;
    }

    $stmt = $conn->prepare("UPDATE keranjang SET jumlah = ? WHERE id_keranjang = ?");
    $stmt->bind_param("ii", $jumlahBaru, $data['id_keranjang']);
    $stmt->execute();

} else {

    $stmt = $conn->prepare("INSERT INTO keranjang (id_user, id_produk, jumlah) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $id_user, $id_produk, $qty);
    $stmt->execute();
}

// redirect balik
header("Location: ../user/dashboard.php?success=1");
exit;
?>