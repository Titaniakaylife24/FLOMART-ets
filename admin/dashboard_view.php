<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>

    <h1>Dashboard Admin</h1>
    <p>Halo, <?= htmlspecialchars($nama); ?></p>

    <p>
        <a href="/FLOMART-ets/admin/produk/tambah.php">Tambah Produk</a>
        <a href="/FLOMART-ets/admin/kategori/index.php">Kelola Kategori</a>
        <a href="../login/logout.php" class="btn-logout">Logout</a>
    </p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID Produk</th>
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
            <?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>
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