function konfirmasiLogout(urlLogout) {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = urlLogout;
    }
}