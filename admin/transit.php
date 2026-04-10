<?php
session_start();

$isLogin = isset($_SESSION['id_user']);
$role = $_SESSION['role'] ?? 'guest';

// kalau sudah login sebagai admin, langsung masuk dashboard admin
if ($isLogin && $role === 'admin') {
    header("Location: /FLOMART-ets/admin/dashboard.php");
    exit;
}

// url tujuan setelah login
$redirect = urlencode('/FLOMART-ets/admin/dashboard.php');
$loginUrl = "/FLOMART-ets/login/login.php?redirect=" . $redirect;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Jualan - Admin FLOMART</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="bg-white rounded-2xl shadow-lg p-10 max-w-4xl w-full flex flex-col md:flex-row items-center justify-between gap-8">
            
            <div class="max-w-xl">
                <h1 class="text-4xl font-bold mb-4 text-green-700">
                    Kelola Toko Anda dengan Mudah
                </h1>
                <p class="text-gray-600 text-lg mb-6">
                    Masuk sebagai admin untuk mulai jualan, mengatur produk, memantau pesanan, dan mengelola toko Anda di FLOMART.
                </p>

                <a href="<?= htmlspecialchars($loginUrl); ?>"
                   class="inline-block bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition">
                    Login
                </a>
            </div>

            <div class="w-full md:w-80">
                <div class="bg-green-50 rounded-2xl p-6 text-center border border-green-100">
                    <div class="text-6xl mb-4">🛍️</div>
                    <h2 class="text-2xl font-semibold mb-2">Versi Admin</h2>
                    <p class="text-gray-500">
                        Akses khusus untuk penjual/admin agar bisa mengelola produk dan toko.
                    </p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>