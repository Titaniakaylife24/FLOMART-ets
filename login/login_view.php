<!DOCTYPE html>
<html>
<head>
    <title>Login FLOMART</title>
    <script src="../assets/js/script.js"></script>
</head>
<body>

<h2>Login</h2>

<form action="proses_login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>

    <label>
        <input type="checkbox" name="remember"> Remember Me
    </label><br><br>

    <button type="submit" name="login">Login</button>
</form>

</body>
</html>