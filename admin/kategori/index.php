<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$queryKategori = "SELECT * FROM kategori ORDER BY id_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

if (!$resultKategori) {
    die("Query kategori gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
</head>
<body>

    <h1>Kelola Kategori</h1>

    <p>
        <a href="../dashboard.php">Kembali ke Dashboard</a> |
        <a href="tambah.php">Tambah Kategori</a>
    </p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID Kategori</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
                <tr>
                    <td><?= $kategori['id_kategori']; ?></td>
                    <td><?= htmlspecialchars($kategori['nama_kategori']); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $kategori['id_kategori']; ?>">Edit</a>
                        |
                        <a href="hapus.php?id=<?= $kategori['id_kategori']; ?>" class="btn-hapus">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script src="../../assets/js/script_admin.js"></script>
</body>
</html>