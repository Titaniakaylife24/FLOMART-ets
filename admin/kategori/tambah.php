<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$error = '';

if (isset($_POST['simpan'])) {
    $nama_kategori = mysqli_real_escape_string($conn, trim($_POST['nama_kategori']));

    if (empty($nama_kategori)) {
        $error = "Nama kategori wajib diisi.";
    } else {
        $queryCek = "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori' LIMIT 1";
        $resultCek = mysqli_query($conn, $queryCek);

        if (!$resultCek) {
            $error = "Gagal mengecek kategori: " . mysqli_error($conn);
        } elseif (mysqli_num_rows($resultCek) > 0) {
            $error = "Kategori sudah ada.";
        } else {
            $queryInsert = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
            $insert = mysqli_query($conn, $queryInsert);

            if ($insert) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Gagal menambahkan kategori: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
</head>
<body>

    <h1>Tambah Kategori</h1>

    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Nama Kategori</label><br>
            <input type="text" name="nama_kategori" required>
        </p>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>

</body>
</html>