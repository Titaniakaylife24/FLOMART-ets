<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID kategori tidak valid.");
}

$queryKategori = "SELECT * FROM kategori WHERE id_kategori = $id LIMIT 1";
$resultKategori = mysqli_query($conn, $queryKategori);

if (!$resultKategori) {
    die("Query kategori gagal: " . mysqli_error($conn));
}

$kategori = mysqli_fetch_assoc($resultKategori);

if (!$kategori) {
    die("Kategori tidak ditemukan.");
}

$error = '';

if (isset($_POST['update'])) {
    $nama_kategori = mysqli_real_escape_string($conn, trim($_POST['nama_kategori']));

    if (empty($nama_kategori)) {
        $error = "Nama kategori wajib diisi.";
    } else {
        $queryCek = "SELECT * FROM kategori 
                     WHERE nama_kategori = '$nama_kategori' 
                     AND id_kategori != $id 
                     LIMIT 1";
        $resultCek = mysqli_query($conn, $queryCek);

        if (!$resultCek) {
            $error = "Gagal mengecek kategori: " . mysqli_error($conn);
        } elseif (mysqli_num_rows($resultCek) > 0) {
            $error = "Nama kategori sudah dipakai kategori lain.";
        } else {
            $queryUpdate = "UPDATE kategori 
                            SET nama_kategori = '$nama_kategori' 
                            WHERE id_kategori = $id";
            $update = mysqli_query($conn, $queryUpdate);

            if ($update) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Gagal mengupdate kategori: " . mysqli_error($conn);
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
    <title>Edit Kategori</title>
</head>
<body>

    <h1>Edit Kategori</h1>

    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Nama Kategori</label><br>
            <input type="text" name="nama_kategori" value="<?= htmlspecialchars($kategori['nama_kategori']); ?>" required>
        </p>

        <button type="submit" name="update">Update</button>
        <a href="index.php">Kembali</a>
    </form>

</body>
</html>