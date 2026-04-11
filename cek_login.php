<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// FIX TANPA UBAH FILE LAIN

if (!function_exists('harusLogin')) {
    function harusLogin() {
        if (!isset($_SESSION['id_user'])) {
            $redirect = urlencode($_SERVER['REQUEST_URI']);
            header("Location: /FLOMART-ets/login/login.php?redirect=$redirect");
            exit;
        }
    }
}

if (!function_exists('cekRole')) {
    function cekRole($role) {
        harusLogin();

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
            header("Location: /FLOMART-ets/login/login.php");
            exit;
        }
    }
}
?>