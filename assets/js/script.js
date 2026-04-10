function konfirmasiLogout(urlLogout) {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = urlLogout;
    }
}

function harusLogin(redirectUrl) {
    if (confirm("Anda harus login terlebih dahulu. Login sekarang?")) {
        window.location.href = "/FLOMART-ets/login/login.php?redirect=" + encodeURIComponent(redirectUrl);
    }
}