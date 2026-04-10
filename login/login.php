<?php
session_start();
include '../koneksi/koneksi.php';

// ambil redirect dari URL login
$redirect = $_POST['redirect'] ?? ($_GET['redirect'] ?? '');

// SESSION TIMEOUT 1 menit
$timeout = 60;

if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_unset();
        session_destroy();
        session_start();
    }
}

// update aktivitas jika session masih ada
if (isset($_SESSION['id_user'])) {
    $_SESSION['last_activity'] = time();
}

// AUTO LOGIN DARI COOKIE
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
        $_SESSION['last_activity'] = time();
    }
}

// REDIRECT JIKA SUDAH LOGIN
if (isset($_SESSION['role'])) {
    if (!empty($redirect)) {
        header("Location: " . $redirect);
        exit;
    }

    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] == 'owner') {
        header("Location: ../pemilik/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] == 'pembeli') {
        header("Location: /FLOMART-ets/index.php");
        exit;
    }
}

include 'login_view.php';
?>