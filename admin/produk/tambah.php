<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$queryKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

if (!$resultKategori) {
    die("Query kategori gagal: " . mysqli_error($conn));
}

$error = '';

if (isset($_POST['simpan'])) {
    $id_kategori = (int) $_POST['id_kategori'];
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = (float) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $gambar = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $folderTujuan = __DIR__ . '/../../assets/img/produk';
        $namaAsli = $_FILES['gambar']['name'];
        $tmpFile = $_FILES['gambar']['tmp_name'];
        $ukuranFile = $_FILES['gambar']['size'];

        $ext = strtolower(pathinfo($namaAsli, PATHINFO_EXTENSION));
        $extDiizinkan = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $extDiizinkan)) {
            $error = "Format gambar harus jpg, jpeg, png, atau webp.";
        } elseif ($ukuranFile > 2 * 1024 * 1024) {
            $error = "Ukuran gambar maksimal 2MB.";
        } else {
            $namaBaru = uniqid('produk_', true) . '.' . $ext;
            $pathSimpan = $folderTujuan . $namaBaru;

            if (move_uploaded_file($tmpFile, $pathSimpan)) {
                $gambar = $namaBaru;
            } else {
                $error = "Gagal upload gambar.";
            }
        }
    } else {
        $error = "Gambar wajib diupload.";
    }

    if (empty($error)) {
        $queryInsert = "INSERT INTO produk (id_kategori, nama_produk, harga, stok, deskripsi, gambar, created_at)
                        VALUES ('$id_kategori', '$nama_produk', '$harga', '$stok', '$deskripsi', '$gambar', NOW())";

        $insert = mysqli_query($conn, $queryInsert);

        if ($insert) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal menambahkan produk: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>
<body>

    <h1>Tambah Produk</h1>

    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <p>
            <label>Kategori</label><br>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
                    <option value="<?= $kategori['id_kategori']; ?>">
                        <?= htmlspecialchars($kategori['nama_kategori']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </p>

        <p>
            <label>Nama Produk</label><br>
            <input type="text" name="nama_produk" required>
        </p>

        <p>
            <label>Harga</label><br>
            <input type="number" name="harga" required>
        </p>

        <p>
            <label>Stok</label><br>
            <input type="number" name="stok" required>
        </p>

        <p>
            <label>Deskripsi</label><br>
            <textarea name="deskripsi" required></textarea>
        </p>

        <p>
            <label>Upload Gambar</label><br>
            <input type="file" name="gambar" accept="image/*" required>
        </p>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>

</body>
</html>