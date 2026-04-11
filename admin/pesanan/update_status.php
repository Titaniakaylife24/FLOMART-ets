<?php
include '../../cek_login.php';
include '../../koneksi/koneksi.php';

cekRole('admin');

$id = (int) $_GET['id'];
$aksi = $_GET['aksi'];

/* cek status dulu (biar tidak bisa double proses) */
$cek = mysqli_query($conn, "
    SELECT status_pesanan FROM pesanan
    WHERE id_pesanan = $id
");

$data = mysqli_fetch_assoc($cek);

/* hanya boleh proses kalau masih menunggu */
if ($data['status_pesanan'] != 'menunggu') {
    header("Location: index.php");
    exit;
}

if ($aksi == 'terima') {

    $status = 'diproses';

} elseif ($aksi == 'tolak') {

    $status = 'dibatalkan';

    /* BALIKKAN STOK */
    $detail = mysqli_query($conn, "
        SELECT * FROM detail_pesanan
        WHERE id_pesanan = $id
    ");

    while ($d = mysqli_fetch_assoc($detail)) {
        mysqli_query($conn, "
            UPDATE produk
            SET stok = stok + {$d['qty']}
            WHERE id_produk = {$d['id_produk']}
        ");
    }

} else {
    header("Location: index.php");
    exit;
}

/* update status */
mysqli_query($conn, "
    UPDATE pesanan 
    SET status_pesanan = '$status'
    WHERE id_pesanan = $id
");

header("Location: index.php");
exit;
?>