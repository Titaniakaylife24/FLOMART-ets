<?php
session_start();
include '../koneksi/koneksi.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // SESSION
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['last_activity'] = time();

        // COOKIE 1 menit
        if (isset($_POST['remember'])) {
            setcookie('email', $user['email'], time() + 60, "/");
        }

        // REDIRECT SESUAI ROLE
        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] == 'owner') {
            header("Location: ../pemilik/dashboard.php");
        } elseif ($user['role'] == 'pembeli') {
            header("Location: ../user/dashboard.php");
        }
        exit;

    } else {
        header("Location: login.php?error=1");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}
?>