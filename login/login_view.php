<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login FLOMART</title>
     <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!--Header-->
<header class="fixed top-0 left-0 w-full flex items-center justify-between px-10 py-4 bg-white/90 backdrop-blur-md shadow z-50">
    <img src="../assets/img/LogoFlomart.png" alt="Logo Flomart" width="150">

    <nav class="space-x-6 text-gray-700 font-medium">
        <a href="#" class="hover:text-green-600">Chat</a>
        <a href="#" class="hover:text-green-600">Pesanan</a>
        <a href="#" class="hover:text-green-600">Notifikasi</a>
        <a href="/FLOMART-ets/keranjang/index.php" class="hover:text-green-600">Keranjang</a>
    </nav>
</header>

<hr>

<!--Main-->
<main class="flex items-center justify-center py-20 bg-gray-50 pt-24"> 
    <div class="flex items-center gap-20 max-w-6xl">
        <!--Konten Kiri-->
        <div>
            <img src="../assets/img/FotoLogin.png" alt="FotoLoginFlomart" width="475">
        </div>

        <!--Konten Kanan-->
        <div class="bg-white p-10 rounded-xl shadow-md w-[380px]">
            <H2 class="text-2xl font-bold mb-6 text-gray-800">Log In</H2>

            <?php if (isset($_GET['error'])): ?>
            <p class="text-red-500 mb-3">Email atau password salah!</p>
            <?php endif; ?>

            <?php if (isset($_GET['timeout'])): ?>
            <p class="text-orange-500 mb-3">Session habis, silakan login lagi.</p>
            <?php endif; ?>

            <form action="proses_login.php" method="POST" class="space-y-4">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect ?? '') ?>">
            <input type="email" name="email" placeholder="Email" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 outline-none"><br>
            <input type="password" name="password" placeholder="Password" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 outline-none"><br><br>

            <label class="flex items-center gap-2 text-sm text-gray-600">
             <input type="checkbox" name="remember"> Remember Me
            </label><br><br>

            <button type="submit" name="login" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 rounded-lg">Login</button>

             <p class="text-sm text-gray-600">
                Belum punya akun? 
            <a href="register.php" class="text-green-600 font-semibold hover:underline hover:text-green-700">
                Daftar
            </a>
</p>
            </form>
        </div>
    </div>
</main>

    <!--Footer-->
    <footer class="bg-green-700 text-white px-16 py-14">

<div class="grid grid-cols-4 gap-10">

    <!-- BRAND -->
    <div>
        <img src="../assets/img/contrasLogoFlomart.png" width="150">

        <p class="text-sm mb-4">
            Marketplace tanaman ramah lingkungan terpercaya
        </p>

        <div class="flex">
            <input type="email"
            placeholder="Write Email"
            class="px-3 py-2 rounded-l-lg text-black w-full bg-white">

            <button class="bg-yellow-400 px-4 rounded-r-lg">
                ➤
            </button>
        </div>

        <p class="text-xs mt-6">
            Copyright <br>
            © 2025 FLOMART. All rights reserved. <br>
            Grow green, live better.
        </p>
    </div>

    <!-- LAYANAN -->
    <div>
        <h3 class="font-semibold mb-4">Layanan</h3>
        <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Belanja Tanaman</a></li>
            <li><a href="#" class="hover:underline">Bibit & Media Tanaman</a></li>
            <li><a href="#" class="hover:underline">Filter Kecocokan Tanaman</a></li>
            <li><a href="#" class="hover:underline">Start Sell (jual tanaman)</a></li>
        </ul>
    </div>

    <!-- BANTUAN -->
    <div>
        <h3 class="font-semibold mb-4">Bantuan</h3>
        <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Cara Belanja</a></li>
            <li><a href="#" class="hover:underline">Cara Menjual Tanaman</a></li>
            <li><a href="#" class="hover:underline">Pengiriman & Perawatan</a></li>
            <li><a href="#" class="hover:underline">Kebijakan Pengembalian</a></li>
        </ul>
    </div>

    <!-- SOSIAL -->
    <div>
        <h3 class="font-semibold mb-4">Ikuti Kami</h3>
        <ul class="space-y-2 text-sm">
            <li>Instagram - @flomart.id</li>
            <li>Facebook - FLOMART</li>
            <li>Twitter/X - @flomart_id</li>
        </ul>
    </div>

</div>

</footer>
</body>
</html>