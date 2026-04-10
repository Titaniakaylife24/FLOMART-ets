<?php
include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$query = "SELECT produk.*, kategori.nama_kategori
          FROM produk
          JOIN kategori ON produk.id_kategori = kategori.id_kategori
          ORDER BY produk.id_produk DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk</title>
</head>
<body>

    <h1>Kelola Produk</h1>

    <p>
        <a href="/FLOMART-ets/admin/dashboard.php">Kembali ke Dashboard</a> |
        <a href="/FLOMART-ets/admin/produk/tambah.php">Tambah Produk</a>
    </p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Created At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($produk = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $produk['id_produk']; ?></td>
                    <td><?= htmlspecialchars($produk['nama_kategori']); ?></td>
                    <td><?= htmlspecialchars($produk['nama_produk']); ?></td>
                    <td><?= $produk['harga']; ?></td>
                    <td><?= $produk['stok']; ?></td>
                    <td><?= htmlspecialchars($produk['deskripsi']); ?></td>
                    <td><?= htmlspecialchars($produk['gambar']); ?></td>
                    <td><?= htmlspecialchars($produk['created_at']); ?></td>
                    <td>
                        <a href="/FLOMART-ets/admin/produk/edit.php?id=<?= $produk['id_produk']; ?>">Edit</a>
                        |
                        <a href="/FLOMART-ets/admin/produk/hapus.php?id=<?= $produk['id_produk']; ?>" class="btn-hapus">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script src="/FLOMART-ets/assets/js/script_admin.js"></script>
</body>
</html>