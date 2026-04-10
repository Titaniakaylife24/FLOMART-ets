<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

$nama = $_SESSION['nama'] ?? 'Guest';
$role = $_SESSION['role'] ?? 'guest';

// ambil kategori
$queryKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

// ambil kategori yang dipilih dari URL
$id_kategori = isset($_GET['kategori']) ? (int) $_GET['kategori'] : 0;

// rekomendasi produk berdasarkan penjualan terbanyak
$queryRekomendasi = "
SELECT 
    produk.*,
    kategori.nama_kategori,
    COALESCE(SUM(detail_pesanan.qty), 0) AS total_terjual
FROM produk
JOIN kategori ON produk.id_kategori = kategori.id_kategori
LEFT JOIN detail_pesanan ON produk.id_produk = detail_pesanan.id_produk
LEFT JOIN pesanan ON detail_pesanan.id_pesanan = pesanan.id_pesanan
WHERE produk.stok > 0
GROUP BY produk.id_produk
ORDER BY total_terjual DESC, produk.id_produk DESC
LIMIT 4
";
$resultRekomendasi = mysqli_query($conn, $queryRekomendasi);

// produk utama
if ($id_kategori > 0) {
    $queryProduk = "SELECT produk.*, kategori.nama_kategori 
                    FROM produk
                    JOIN kategori ON produk.id_kategori = kategori.id_kategori
                    WHERE produk.id_kategori = $id_kategori
                    ORDER BY produk.id_produk DESC";
} else {
    $queryProduk = "SELECT produk.*, kategori.nama_kategori 
                    FROM produk
                    JOIN kategori ON produk.id_kategori = kategori.id_kategori
                    ORDER BY produk.id_produk DESC";
}
$resultProduk = mysqli_query($conn, $queryProduk);

include 'dashboard_view.php';
?>