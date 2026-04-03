<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] == 'owner') {
        header("Location: ../pemilik/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] == 'pembeli') {
        header("Location: ../user/dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login FLOMART</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="min-h-screen bg-[#f6f4f4] flex items-center justify-center px-4 py-10 font-sans">
    <div class="w-full max-w-sm">
    <h2 class="text-center text-2xl font-bold text-gray-900 mb-6">Login FLOMART</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="mb-4 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-center text-sm font-medium text-red-600">Email atau password salah!</p>
    <?php endif; ?>

    <?php if (isset($_GET['logout'])): ?>
        <p style="color:green;">Berhasil logout.</p>
    <?php endif; ?>

    <form action="proses_login.php" method="POST" class="rounded-[28px] bg-white px-6 py-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)] border border-gray-100">
        <label class="mb-2 block text-sm font-semibold text-gray-800">Email</label><br>
        <input type="email" name="email" required class="w-full rounded-full border border-[#2f9e44] bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-[#1b7f35] focus:ring-4 focus:ring-green-100 placeholder:text-gray-400"><br><br>

        <label class="mb-2 block text-sm font-semibold text-gray-800">Password</label><br>
        <input type="password" name="password" required class="w-full rounded-full border border-[#2f9e44] bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-[#1b7f35] focus:ring-4 focus:ring-green-100 placeholder:text-gray-400"><br><br>

        <button type="submit" name="login" w-full rounded-full bg-[#e0b800] px-4 py-3 text-sm font-bold text-black shadow-sm transition hover:brightness-95 active:scale-[0.99]>Login</button>
    </form>

    <p class="mt-5 text-center text-sm text-gray-600">Belum punya akun? <a href="register.php" class="font-semibold text-[#1b7f35] hover:underline">Daftar</a></p>
    </div>
</body>
</html>