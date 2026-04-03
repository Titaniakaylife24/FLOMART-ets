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
<body>
    <h2>Login FLOMART</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;">Email atau password salah!</p>
    <?php endif; ?>

    <?php if (isset($_GET['logout'])): ?>
        <p style="color:green;">Berhasil logout.</p>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">
        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</body>
</html>