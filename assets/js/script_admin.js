document.addEventListener("DOMContentLoaded", function () {
    const tombolHapus = document.querySelectorAll(".btn-hapus");

    tombolHapus.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            const yakin = confirm("Yakin ingin menghapus produk ini?");
            if (!yakin) {
                e.preventDefault();
            }
        });
    });

    const tombolLogout = document.querySelector(".btn-logout");

    if (tombolLogout) {
        tombolLogout.addEventListener("click", function (e) {
            const konfirmasi = confirm("Yakin ingin logout?");
            if (!konfirmasi) {
                e.preventDefault();
            }
        });
    }

});