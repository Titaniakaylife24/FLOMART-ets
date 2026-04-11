<?php
include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$id = $_GET['id'];

$produk = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM produk WHERE id_produk=$id"));

$resultKategori = mysqli_query($conn,"SELECT * FROM kategori");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$gambar = $produk['gambar'];

if ($_FILES['gambar']['error'] == 0) {

$folder = __DIR__ . '/../../uploads/produk/';
$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
$namaBaru = uniqid().'.'.$ext;

move_uploaded_file($_FILES['gambar']['tmp_name'],$folder.$namaBaru);

$gambar = $namaBaru;
}

mysqli_query($conn,"UPDATE produk SET
id_kategori='$_POST[id_kategori]',
nama_produk='$_POST[nama_produk]',
harga='$_POST[harga]',
stok='$_POST[stok]',
deskripsi='$_POST[deskripsi]',
gambar='$gambar'
WHERE id_produk=$id");

header("Location: /FLOMART-ets/admin/dashboard_view.php");header("Location: /FLOMART-ets/admin/dashboard_view.php");
exit;}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Edit Produk
        </h1>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Kategori
                </label>
                <select name="id_kategori"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php while($k=mysqli_fetch_assoc($resultKategori)): ?>
                    <option value="<?= $k['id_kategori']; ?>"
                    <?= $k['id_kategori']==$produk['id_kategori']?'selected':'' ?>>
                        <?= $k['nama_kategori']; ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Nama Produk
                </label>
                <input type="text" name="nama_produk"
                    value="<?= $produk['nama_produk']; ?>"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Harga
                </label>
                <input type="number" name="harga"
                    value="<?= $produk['harga']; ?>"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Stok
                </label>
                <input type="number" name="stok"
                    value="<?= $produk['stok']; ?>"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Deskripsi
                </label>
                <textarea name="deskripsi" rows="4"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $produk['deskripsi']; ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Saat Ini
                </label>
                <div class="flex justify-center">
                    <img src="/FLOMART-ets/uploads/produk/<?= $produk['gambar']; ?>"
                        class="w-24 h-24 object-cover rounded-xl border shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Upload Gambar Baru
                </label>
                <input type="file" name="gambar"
                    class="w-full border border-gray-300 rounded-lg p-2 bg-gray-50">
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-200">
                    Update
                </button>

                <a href="/FLOMART-ets/admin/dashboard_view.php"
                    onclick="return confirm('Yakin tidak jadi edit produk?')"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg text-center font-semibold transition duration-200">
                    Batal
                </a>
            </div>

        </form>
    </div>

</body>
</html>