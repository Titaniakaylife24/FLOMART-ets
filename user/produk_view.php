<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk FLOMART</title>
    <script src="../assets/js/script.js"></script>
</head>
<body>

    <h1>Daftar Produk FLOMART</h1>
    <p>Halo, <?= $_SESSION['nama']; ?>!</p>

    <a href="dashboard.php">Kembali ke Dashboard</a>
    <br><br>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
            </tr>

            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama_produk']; ?></td>
                    <td><?= $row['nama_kategori']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td><?= $row['deskripsi']; ?></td>
                    <td>
                        <?php if (!empty($row['gambar'])): ?>
                            <img src="../assets/img/<?= $row['gambar']; ?>" width="80">
                        <?php else: ?>
                            Tidak ada gambar
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Belum ada produk.</p>
    <?php endif; ?>

    <br>
    <button onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')">Logout</button>

</body>
</html>