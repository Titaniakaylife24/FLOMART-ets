<?php
include '../cek_login.php';
cekRole('admin');

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

include 'dashboard_view.php';
?>