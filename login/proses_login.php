<?php
session_start();
include '../koneksi/koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['role']    = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
            exit;
        } elseif ($user['role'] == 'owner') {
            header("Location: ../pemilik/dashboard.php");
            exit;
        } elseif ($user['role'] == 'pembeli') {
            header("Location: ../user/dashboard.php");
            exit;
        } else {
            header("Location: login.php?error=1");
            exit;
        }
    } else {
        header("Location: login.php?error=1");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>