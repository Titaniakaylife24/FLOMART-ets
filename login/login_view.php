<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login FLOMART</title>
</head>
<body>

<h2>Login FLOMART</h2>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red;">Email atau password salah!</p>
<?php endif; ?>

<?php if (isset($_GET['timeout'])): ?>
    <p style="color:orange;">Session habis, silakan login lagi.</p>
<?php endif; ?>

<form action="proses_login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <label>
        <input type="checkbox" name="remember"> Remember Me
    </label><br><br>

    <button type="submit" name="login">Login</button>
</form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</body>
</html>