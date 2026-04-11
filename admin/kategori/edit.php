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
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Edit Kategori
        </h1>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-600 border border-red-300 rounded-lg p-3 mb-4 text-sm">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Nama Kategori
                </label>
                <input 
                    type="text" 
                    name="nama_kategori"
                    value="<?= htmlspecialchars($kategori['nama_kategori']); ?>" 
                    required
                    placeholder="Masukkan nama kategori"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" name="update"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-200">
                    Update
                </button>

                <a href="index.php"
                    onclick="return confirm('Yakin tidak jadi edit kategori?')"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg text-center font-semibold transition duration-200">
                    Kembali
                </a>
            </div>

        </form>
    </div>

</body>
</html>