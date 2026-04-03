<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] == 'owner') {
        header("Location: pemilik/dashboard.php");
        exit;
    } elseif ($_SESSION['role'] == 'pembeli') {
        header("Location: user/dashboard.php");
        exit;
    }
}

header("Location: login/login.php");
exit;
?>