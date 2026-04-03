<?php
include '../cek_login.php';
cekRole('owner');

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

include 'dashboard_view.php';
?>