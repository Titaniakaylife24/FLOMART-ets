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
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="min-h-screen bg-[#f5f3f3] flex items-center justify-center px-4 font-sans text-gray-800">
    <div class="w-full max-w-[420px]">  
<h2 class="mb-6 text-center text-3xl font-extrabold tracking-tight text-gray-900">Login FLOMART</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;" class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-600 shadow-sm">Email atau password salah!</p>
    <?php endif; ?>

    <?php if (isset($_GET['logout'])): ?>
        <p style="color:green;" class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-600 shadow-sm">Berhasil logout.</p>
    <?php endif; ?>

    <form action="proses_login.php" method="POST" class="rounded-[32px] bg-white px-7 py-8 shadow-[0_20px_60px_rgba(0,0,0,0.08)] border border-white/80 backdrop-blur">
        <label class="mb-2 block text-sm font-semibold text-gray-700">Email</label><br>
        <input type="email" name="email" required class="w-full rounded-full border border-[#46a85f] bg-white px-5 py-3 text-sm text-gray-700 outline-none transition duration-200 placeholder:text-gray-400 focus:border-[#2f8f48] focus:ring-4 focus:ring-green-100"><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login" class="w-full rounded-full bg-[#e0bc10] px-5 py-3 text-sm font-bold text-black shadow-[0_8px_20px_rgba(224,188,16,0.28)] transition duration-200 hover:scale-[1.01] hover:brightness-95 active:scale-[0.99]">Login</button>
    </form>

    <p class="mt-5 text-center text-sm text-gray-600">Belum punya akun? <a href="register.php" class="font-bold text-[#2f8f48] transition hover:text-[#26753b] hover:underline">Daftar</a></p>
    </div>
</body>
</html>