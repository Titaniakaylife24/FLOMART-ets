<?php
session_start();
include '../koneksi/koneksi.php';

// AUTO LOGIN dari COOKIE
if (!isset($_SESSION['id_user']) && isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];

    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
    }
}
// kalau sudah login, redirect
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

// panggil HTML
include 'login_view.php';
?>