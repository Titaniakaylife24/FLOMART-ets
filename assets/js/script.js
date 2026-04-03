document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("btnLogout");

    if (btn) {
        btn.addEventListener("click", function (e) {
            if (!confirm("Apakah Anda yakin ingin logout?")) {
                e.preventDefault();
            }
        });
    }
});