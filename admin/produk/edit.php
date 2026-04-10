<?php
include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID produk tidak valid.");
}

$queryProduk = "SELECT * FROM produk WHERE id_produk = $id LIMIT 1";
$resultProduk = mysqli_query($conn, $queryProduk);
$produk = mysqli_fetch_assoc($resultProduk);

if (!$produk) {
    die("Produk tidak ditemukan.");
}

$queryKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

$error = '';

if (isset($_POST['update'])) {
    $id_kategori = (int) $_POST['id_kategori'];
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = (float) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $gambar = mysqli_real_escape_string($conn, $_POST['gambar']);

    $queryUpdate = "UPDATE produk
                    SET id_kategori='$id_kategori',
                        nama_produk='$nama_produk',
                        harga='$harga',
                        stok='$stok',
                        deskripsi='$deskripsi',
                        gambar='$gambar'
                    WHERE id_produk='$id'";

    $update = mysqli_query($conn, $queryUpdate);

    if ($update) {
        header("Location: /FLOMART-ets/admin/produk/index.php");
        exit;
    } else {
        $error = "Gagal mengupdate produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
</head>
<body>

    <h1>Edit Produk</h1>

    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Kategori</label><br>
            <select name="id_kategori" required>
                <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
                    <option value="<?= $kategori['id_kategori']; ?>"
                        <?= $kategori['id_kategori'] == $produk['id_kategori'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($kategori['nama_kategori']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </p>

        <p>
            <label>Nama Produk</label><br>
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']); ?>" required>
        </p>

        <p>
            <label>Harga</label><br>
            <input type="number" name="harga" value="<?= $produk['harga']; ?>" required>
        </p>

        <p>
            <label>Stok</label><br>
            <input type="number" name="stok" value="<?= $produk['stok']; ?>" required>
        </p>

        <p>
            <label>Deskripsi</label><br>
            <textarea name="deskripsi" required><?= htmlspecialchars($produk['deskripsi']); ?></textarea>
        </p>

        <p>
            <label>Nama File Gambar</label><br>
            <input type="text" name="gambar" value="<?= htmlspecialchars($produk['gambar']); ?>" required>
        </p>

        <button type="submit" name="update">Update</button>
        <a href="/FLOMART-ets/admin/produk/index.php">Kembali</a>
    </form>

</body>
</html>