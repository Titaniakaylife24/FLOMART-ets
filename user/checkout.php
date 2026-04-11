<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

harusLogin();

$id_user = $_SESSION['id_user'];
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
//Validasi//
if (empty($nama) || empty($no_hp)) {
    die("Nama dan No HP wajib diisi");
}

$selected_items = $_POST['selected_items'] ?? [];
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
$ongkir = (int) $_POST['ongkir'];
$metode = $_POST['metode'] ?? 'COD';
$catatan = mysqli_real_escape_string($conn, $_POST['catatan'] ?? '');

/* TAMBAHAN PENTING */
$nama = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
$no_hp = mysqli_real_escape_string($conn, $_POST['no_hp'] ?? '');

if (empty($selected_items)) {
    die("Pilih produk terlebih dahulu");
}

if (empty($alamat)) {
    die("Alamat tidak boleh kosong");
}

if (empty($nama) || empty($no_hp)) {
    die("Nama dan No HP wajib diisi");
}

$ids = implode(',', array_map('intval', $selected_items));

$query = "
SELECT keranjang.id_produk, keranjang.jumlah, produk.harga
FROM keranjang
JOIN produk ON keranjang.id_produk = produk.id_produk
WHERE keranjang.id_keranjang IN ($ids)
AND keranjang.id_user = $id_user
";

$result = mysqli_query($conn, $query);

$subtotal = 0;
$items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $sub = $row['harga'] * $row['jumlah'];
    $subtotal += $sub;

    $items[] = [
        'id_produk' => $row['id_produk'],
        'qty' => $row['jumlah'],
        'harga' => $row['harga'],
        'subtotal' => $sub
    ];
}

$total = $subtotal + $ongkir;

$status = ($metode == 'COD') ? 'diproses' : 'menunggu';

mysqli_query($conn, "
INSERT INTO pesanan (
    id_user,
    nama_penerima,
    no_hp,
    total_harga,
    alamat_kirim,
    metode_pembayaran,
    status_pesanan,
    catatan
) VALUES (
    $id_user,
    '$nama',
    '$no_hp',
    '$total',
    '$alamat',
    '$metode',
    '$status',
    '$catatan'
)
");

$id_pesanan = mysqli_insert_id($conn);

foreach ($items as $item) {
    mysqli_query($conn, "
    INSERT INTO detail_pesanan (
        id_pesanan, id_produk, qty, harga, subtotal
    ) VALUES (
        $id_pesanan,
        {$item['id_produk']},
        {$item['qty']},
        {$item['harga']},
        {$item['subtotal']}
    )
    ");

    // KURANGI STOK
    mysqli_query($conn, "
    UPDATE produk 
    SET stok = stok - {$item['qty']}
    WHERE id_produk = {$item['id_produk']}
    ");
}

mysqli_query($conn, "
DELETE FROM keranjang 
WHERE id_keranjang IN ($ids)
AND id_user = $id_user
");

if ($metode == 'Transfer') {
    header("Location: pembayaran.php?id=$id_pesanan");
} else {
    header("Location: pesanan_saya.php?success=1");
}
exit;