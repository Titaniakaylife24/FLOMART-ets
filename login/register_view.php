<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register FLOMART</title>
</head>
<body>

    <h2>Register FLOMART</h2>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'email'): ?>
        <p style="color:red;">Email sudah terdaftar!</p>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'kosong'): ?>
        <p style="color:red;">Semua field wajib diisi!</p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;">Registrasi berhasil, silakan login.</p>
    <?php endif; ?>

    <form action="proses_register.php" method="POST">
        <input type="text" name="nama" placeholder="Nama lengkap" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <textarea name="alamat" placeholder="Alamat" required></textarea><br>
        <input type="text" name="no_hp" placeholder="No HP" required><br>

        <button type="submit" name="register">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login</a></p>

</body>
</html>