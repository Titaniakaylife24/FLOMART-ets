<?php
include '../koneksi/koneksi.php';

if (isset($_POST['register'])) {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);

    // validasi kosong
    if ($nama == "" || $email == "" || $password == "" || $alamat == "" || $no_hp == "") {
        header("Location: register.php?error=kosong");
        exit;
    }

    // cek email sudah ada atau belum
    $cekEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($cekEmail) > 0) {
        header("Location: register.php?error=email");
        exit;
    }

    // simpan user baru sebagai pembeli
    $query = "INSERT INTO users (nama, email, password, role, alamat, no_hp)
              VALUES ('$nama', '$email', '$password', 'pembeli', '$alamat', '$no_hp')";

    if (mysqli_query($conn, $query)) {
        header("Location: register.php?success=1");
        exit;
    } else {
        echo "Registrasi gagal: " . mysqli_error($conn);
    }

} else {
    header("Location: register.php");
    exit;
}
?>