<?php
session_start();

$timeout = 60;

if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_unset();
        session_destroy();
        header("Location: /FLOMART-ets/login/login.php?timeout=1");
        exit;
    }
}

if (isset($_SESSION['id_user'])) {
    $_SESSION['last_activity'] = time();
}

function harusLogin() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: /FLOMART-ets/login/login.php");
        exit;
    }
}

function cekRole($role) {
    harusLogin();

    if ($_SESSION['role'] != $role) {
        echo "Akses ditolak!";
        exit;
    }
}
?>