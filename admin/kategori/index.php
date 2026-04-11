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
    <link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-8">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Kelola Kategori
            </h1>

            <div class="flex gap-3">
                <a href="../dashboard.php"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Dashboard
                </a>

                <a href="tambah.php"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    + Tambah Kategori
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100\ text-gray-700">
                        <th class="p-3 text-left border-b">ID Kategori</th>
                        <th class="p-3 text-left border-b">Nama Kategori</th>
                        <th class="p-3 text-center border-b">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-3 border-b">
                            <?= $kategori['id_kategori']; ?>
                        </td>

                        <td class="p-3 border-b">
                            <?= htmlspecialchars($kategori['nama_kategori']); ?>
                        </td>

                        <td class="p-3 border-b text-center">
                            <div class="flex justify-center gap-2">
                                <a href="edit.php?id=<?= $kategori['id_kategori']; ?>"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm">
                                    Edit
                                </a>

                                <a href="hapus.php?id=<?= $kategori['id_kategori']; ?>"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm btn-hapus">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="../../assets/js/script_admin.js"></script>
</body>
</html>