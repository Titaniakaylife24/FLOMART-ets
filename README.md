FLOMART - E-Commerce Tanaman

Deskripsi Aplikasi:

FLOMART adalah aplikasi berbasis web yang berfungsi sebagai platform e-commerce untuk penjualan produk benih tanaman. Aplikasi ini dirancang untuk mempermudah proses jual beli antara penjual dan pembeli, serta membantu pengelolaan data produk, pesanan, dan laporan penjualan secara terintegrasi.

Aplikasi memiliki tiga role utama:

1. Pembeli: melakukan pembelian produk
2. Admin: mengelola produk, kategori, dan pesanan
3. Owner: memantau laporan dan performa bisnis


Anggota Kelompok:
1. Septian Listia Tri Cahyo - 24082010004 : Frontend (implementasi tampilan web dari design)
2. Titania Kaylife Putri - 24082010022 : Backend (logika sistem, database, CRUD, proses transaksi)
3. Daniel - 24082010045 - Design UI/UX (perancangan tampilan menggunakan Figma)

Pembagian Tugas

1. Frontend (Septian)
Implementasi tampilan dari Figma ke web
Menggunakan Tailwind CSS
Integrasi frontend dengan backend
Responsive design

2. Backend (Titania)
Membuat struktur database
Implementasi CRUD produk & kategori
Sistem autentikasi (login & register)
Proses checkout & transaksi
Validasi pembayaran (Transfer & COD)
Pengelolaan status pesanan

3. Design UI/UX (Daniel)
Mendesain tampilan aplikasi menggunakan Figma
Menentukan layout, warna, dan user experience
Mendesain halaman: Login & Register, Dashboard, Produk & kategori, serta Laporan

Fitur Aplikasi
1. Pembeli
* Registrasi & Login
* Melihat produk
* Menambahkan ke keranjang
* Checkout pesanan
* Pilih metode pembayaran (Transfer / COD)
* Upload bukti pembayaran
* Melihat status pesanan

2. Admin
* Dashboard ringkasan
* CRUD Produk
* CRUD Kategori
* Kelola pesanan
* Verifikasi pembayaran
* Update status pesanan (Menunggu → Diproses / Ditolak)
* Notifikasi pesanan baru

3. Owner
* Dashboard ringkasan bisnis
* Laporan penjualan (filter bulan & tahun)
* Data transaksi
* Analisis produk terlaris
* Monitoring pendapatan

Tech Stack
1. Backend: PHP Native
2. Frontend: HTML, JavaScript
3. Styling: Tailwind CSS
4. Database: MySQL
5. Design: Figma
6. Server: XAMPP / Localhost

Alur Sistem Singkat

1. User registrasi → otomatis menjadi pembeli
2. Pembeli melakukan checkout
3. Jika transfer → upload bukti pembayaran
4. Admin melakukan verifikasi
5. Status pesanan diperbarui
6. Data masuk ke laporan owner