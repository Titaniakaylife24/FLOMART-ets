<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

harusLogin();

$id_user = $_SESSION['id_user'];

$query = "
SELECT keranjang.*, produk.nama_produk, produk.harga
FROM keranjang
JOIN produk ON keranjang.id_produk = produk.id_produk
WHERE keranjang.id_user = $id_user
";

$result = mysqli_query($conn, $query);
?>

<h2>Keranjang Saya</h2>

<?php if (mysqli_num_rows($result) == 0): ?>
    <p>Keranjang kosong</p>
<?php else: ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div>
            <h3><?= $row['nama_produk']; ?></h3>
            <p>Harga: <?= $row['harga']; ?></p>
            <p>Jumlah: <?= $row['jumlah']; ?></p>
        </div>
        <hr>
    <?php endwhile; ?>

    <a href="checkout.php">
        <button>Checkout</button>
    </a>
<?php endif; ?>