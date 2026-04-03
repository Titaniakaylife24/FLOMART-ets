function konfirmasiLogout() {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = "../login/logout.php";
    }
}