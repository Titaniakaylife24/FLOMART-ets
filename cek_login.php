<?php
session_start();

function harusLogin() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: /FLOMART-ets/login/login.php");
        exit;
    }
}

function cekRole($role) {
    harusLogin();

    if (!isset($_SESSION['role']) || $_SESSION['role'] != $role) {
        echo "Akses ditolak!";
        exit;
    }
}
?>