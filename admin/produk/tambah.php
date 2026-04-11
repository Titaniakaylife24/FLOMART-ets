<?php
include __DIR__ . '/../../cek_login.php';
include __DIR__ . '/../../koneksi/koneksi.php';

cekRole('admin');

$resultKategori = mysqli_query($conn, "SELECT * FROM kategori");

$error = '';

if (isset($_POST['simpan'])) {

    $id_kategori = (int) $_POST['id_kategori'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $gambar = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

        $folder = __DIR__ . '/../../uploads/produk/';
        if (!is_dir($folder)) mkdir($folder, 0777, true);

        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];

        if (!in_array($ext, $allowed)) {
            $error = "Format gambar tidak valid";
        } else {

            $namaBaru = uniqid('produk_') . '.' . $ext;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $folder . $namaBaru)) {
                $gambar = $namaBaru;
            } else {
                $error = "Upload gagal";
            }
        }
    } else {
        $error = "Gambar wajib diupload";
    }

    if (empty($error)) {

        $query = "INSERT INTO produk 
        (id_kategori,nama_produk,harga,stok,deskripsi,gambar,created_at)
        VALUES ('$id_kategori','$nama','$harga','$stok','$deskripsi','$gambar',NOW())";

        if (mysqli_query($conn, $query)) {
            header("Location: /FLOMART-ets/admin/dashboard_view.php?success=1");
            exit;
        } else {
            $error = mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Tambah Produk
        </h1>

        <?php if($error): ?>
        <div class="bg-red-100 text-red-600 border border-red-300 rounded-lg p-3 mb-4 text-sm">
            <?= $error ?>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Kategori
                </label>
                <select name="id_kategori" required
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                    <?php while($k=mysqli_fetch_assoc($resultKategori)): ?>
                    <option value="<?= $k['id_kategori']; ?>">
                        <?= $k['nama_kategori']; ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Nama Produk
                </label>
                <input type="text" name="nama_produk" placeholder="Masukkan nama produk"
                    required
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Harga
                </label>
                <input type="number" name="harga" placeholder="Masukkan harga"
                    required
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Stok
                </label>
                <input type="number" name="stok" placeholder="Masukkan stok"
                    required
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Deskripsi
                </label>
                <textarea name="deskripsi" rows="4" required
                    placeholder="Masukkan deskripsi produk"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Upload Gambar
                </label>
                <input type="file" name="gambar" required
                    class="w-full border border-gray-300 rounded-lg p-2 bg-gray-50">
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" name="simpan"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition duration-200">
                    Simpan
                </button>

                <a href="/FLOMART-ets/admin/dashboard_view.php"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg text-center font-semibold transition duration-200">
                    Batal
                </a>
            </div>

        </form>
    </div>

</body>
</html>