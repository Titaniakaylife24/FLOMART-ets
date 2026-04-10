<?php
function getEmoji($namaProduk) {
    $nama = strtolower($namaProduk);

    if (strpos($nama, 'kubis') !== false) return '🥬';
    if (strpos($nama, 'sawi') !== false) return '🥗';
    if (strpos($nama, 'labu') !== false) return '🎃';
    if (strpos($nama, 'tomat') !== false) return '🍅';
    if (strpos($nama, 'jagung') !== false) return '🌽';
    if (strpos($nama, 'mint') !== false) return '🌿';
    if (strpos($nama, 'mawar') !== false) return '🌹';
    if (strpos($nama, 'kelengkeng') !== false) return '🥭';

    return '🌱';
}

$isLogin = isset($_SESSION['id_user']);
$isPembeli = isset($_SESSION['role']) && $_SESSION['role'] === 'pembeli';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard FLOMART</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .page-wrapper {
            max-width: 1280px;
            margin: 0 auto;
            padding: 140px 24px 40px;
        }

        .top-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            z-index: 999;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 40px;
        }

        .brand-title {
            font-size: 28px;
            font-weight: 800;
            color: #16a34a;
            letter-spacing: 0.5px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .nav-link {
            color: #374151;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #16a34a;
        }

        .auth-btn,
        .logout-btn,
        .cart-btn,
        .primary-btn,
        .login-btn {
            border: none;
            cursor: pointer;
            transition: 0.25s ease;
            font-weight: 600;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        .login-btn {
            background: #16a34a;
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            display: inline-block;
        }

        .login-btn:hover {
            background: #15803d;
        }

        .menu-bar {
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: center;
            gap: 36px;
            padding: 14px 20px;
            flex-wrap: wrap;
        }

        .menu-item {
            color: #4b5563;
            font-weight: 500;
            padding-bottom: 4px;
            transition: 0.2s;
        }

        .menu-item.active,
        .menu-item:hover {
            color: #16a34a;
            border-bottom: 2px solid #16a34a;
        }

        .welcome-section {
            margin-bottom: 24px;
        }

        .welcome-section h1 {
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .banner {
            margin-bottom: 36px;
            border-radius: 24px;
            padding: 48px;
            background: linear-gradient(135deg, #fef3c7 0%, #dcfce7 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
            overflow: hidden;
        }

        .banner-content h2 {
            font-size: 42px;
            line-height: 1.2;
            margin-bottom: 18px;
            color: #111827;
        }

        .banner-content p {
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 24px;
            font-size: 16px;
        }

        .primary-btn {
            display: inline-block;
            background: #f59e0b;
            color: white;
            padding: 14px 24px;
            border-radius: 999px;
        }

        .primary-btn:hover {
            background: #16a34a;
        }

        .banner-visual {
            min-width: 260px;
            min-height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 90px;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-header {
            margin-bottom: 18px;
        }

        .section-header h2 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .section-header p {
            color: #6b7280;
            line-height: 1.6;
        }

        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 12px;
        }

        .category-list a,
        .category-list strong {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 14px;
        }

        .category-list a {
            background: #ffffff;
            border: 1px solid #d1d5db;
            color: #374151;
            transition: 0.2s;
        }

        .category-list a:hover {
            background: #ecfdf5;
            border-color: #86efac;
            color: #15803d;
        }

        .category-list strong {
            background: #16a34a;
            color: white;
            font-weight: 600;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
        }

        .product-card {
            background: white;
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 290px;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.10);
        }

        .product-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            gap: 10px;
        }

        .badge {
            background: #dcfce7;
            color: #15803d;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 999px;
        }

        .sold-info {
            font-size: 12px;
            color: #f59e0b;
            font-weight: 700;
        }

        .emoji-box {
            text-align: center;
            font-size: 54px;
            margin-bottom: 16px;
        }

        .product-info p.category {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 8px;
        }

        .product-info h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #111827;
        }

        .price {
            color: #16a34a;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .desc {
            font-size: 13px;
            color: #9ca3af;
            line-height: 1.5;
        }

        .card-action {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .cart-btn {
            background: #facc15;
            color: #111827;
            width: 44px;
            height: 44px;
            border-radius: 999px;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-btn:hover {
            background: #eab308;
        }

        .divider {
            border: none;
            border-top: 1px solid #d1d5db;
            margin: 28px 0;
        }

        .secondary-auth {
            margin: 18px 0 10px;
        }

        @media (max-width: 1100px) {
            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 860px) {
            .page-wrapper {
                padding: 160px 18px 32px;
            }

            .top-bar {
                padding: 16px 20px;
            }

            .banner {
                padding: 32px 24px;
            }

            .banner-content h2 {
                font-size: 32px;
            }

            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .menu-bar {
                gap: 18px;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .welcome-section h1 {
                font-size: 24px;
            }

            .section-header h2 {
                font-size: 24px;
            }

            .banner-content h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<header class="top-header">
    <div class="top-bar">
        <div class="brand-title">FLOMART</div>

        <div class="top-actions">
            <a href="/FLOMART-ets/user/dashboard.php" class="nav-link">Dashboard</a>

            <?php if (isset($_SESSION['id_user'])): ?>
                <a href="/FLOMART-ets/keranjang/index.php" class="nav-link">Keranjang</a>
                <button class="logout-btn" onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')">Logout</button>
            <?php else: ?>
                <a href="/FLOMART-ets/login/login.php" class="login-btn">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <nav class="menu-bar">
        <a href="/FLOMART-ets/user/dashboard.php" class="menu-item active">Beranda</a>
        <a href="#" class="menu-item">Toko</a>
        <a href="#" class="menu-item">Mulai Jualan</a>
        <a href="#" class="menu-item">Blog</a>
        <a href="#" class="menu-item">Tentang Kami</a>
    </nav>
</header>

<div class="page-wrapper">

    <section class="welcome-section">
        <h1>Selamat datang, <?= htmlspecialchars($nama); ?>!</h1>
    </section>

    <?php if ($isLogin): ?>
        <div class="secondary-auth">
            <button type="button" class="logout-btn" onclick="konfirmasiLogout('/FLOMART-ets/login/logout.php')">Logout</button>
        </div>
    <?php else: ?>
        <div class="secondary-auth">
            <a href="/FLOMART-ets/login/login.php" class="login-btn">Login</a>
        </div>
    <?php endif; ?>

    <section class="banner">
        <div class="banner-content">
            <h2>
                Belanja Pintar <br>
                untuk Masa Depan <br>
                yang Lebih Hijau
            </h2>

            <p>
                Temukan produk tanaman ramah lingkungan dari penjual terpercaya
                dengan proses belanja yang mudah dan aman.
            </p>

            <a href="#produk" class="primary-btn">Belanja Sekarang</a>
        </div>

        <div class="banner-visual">🌱</div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2>Rekomendasi Benih Berkualitas</h2>
            <p>Produk rekomendasi berdasarkan jumlah penjualan terbanyak.</p>
        </div>

        <div class="product-grid">
            <?php while ($rekom = mysqli_fetch_assoc($resultRekomendasi)): ?>
                <div class="product-card">
                    <div>
                        <div class="product-top">
                            <span class="badge">Rekomendasi</span>
                            <span class="sold-info">Terjual: <?= (int)$rekom['total_terjual']; ?></span>
                        </div>

                        <div class="emoji-box">
                            <span><?= getEmoji($rekom['nama_produk']); ?></span>
                        </div>

                        <div class="product-info">
                            <p class="category"><?= htmlspecialchars($rekom['nama_kategori']); ?></p>
                            <h3><?= htmlspecialchars($rekom['nama_produk']); ?></h3>
                            <p class="price">Rp <?= number_format($rekom['harga'], 0, ',', '.'); ?></p>
                            <p class="desc">Benih unggulan • Siap tanam • Kualitas premium</p>
                        </div>
                    </div>

                    <div class="card-action">
                        <?php if ($isPembeli): ?>
                            <a href="/FLOMART-ets/keranjang/tambah.php?id=<?= $rekom['id_produk']; ?>">
                                <button type="button" class="cart-btn">🛒</button>
                            </a>
                        <?php else: ?>
                            <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $rekom['id_produk']); ?>
                            <button type="button" class="cart-btn" onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')">🛒</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <hr class="divider">

    <section class="section">
        <div class="section-header">
            <h2>Pilihan Benih Terbaik</h2>
            <p>Pilih produk berdasarkan kategori yang kamu inginkan.</p>
        </div>

        <div class="category-list">
            <a href="/FLOMART-ets/user/dashboard.php"><strong>Semua</strong></a>

            <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
                <a href="/FLOMART-ets/user/dashboard.php?kategori=<?= $kategori['id_kategori']; ?>">
                    <?= htmlspecialchars($kategori['nama_kategori']); ?>
                </a>
            <?php endwhile; ?>
        </div>
    </section>

    <hr class="divider">

    <section class="section" id="produk">
        <div class="product-grid">
            <?php while ($produk = mysqli_fetch_assoc($resultProduk)): ?>
                <div class="product-card">
                    <div>
                        <div class="product-top">
                            <span class="badge">Produk Pilihan</span>
                            <span class="sold-info">Siap Tanam</span>
                        </div>

                        <div class="emoji-box">
                            <span><?= getEmoji($produk['nama_produk']); ?></span>
                        </div>

                        <div class="product-info">
                            <p class="category"><?= htmlspecialchars($produk['nama_kategori']); ?></p>
                            <h3><?= htmlspecialchars($produk['nama_produk']); ?></h3>
                            <p class="price">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
                            <p class="desc">Siap tanam • Kualitas premium</p>
                        </div>
                    </div>

                    <div class="card-action">
                        <?php if ($isPembeli): ?>
                            <a href="/FLOMART-ets/keranjang/tambah.php?id=<?= $produk['id_produk']; ?>">
                                <button type="button" class="cart-btn">🛒</button>
                            </a>
                        <?php else: ?>
                            <?php $loginUrl = "/FLOMART-ets/login/login.php?redirect=" . urlencode("/FLOMART-ets/keranjang/tambah.php?id=" . $produk['id_produk']); ?>
                            <button type="button" class="cart-btn" onclick="konfirmasiLogin('<?= htmlspecialchars($loginUrl, ENT_QUOTES); ?>')">🛒</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</div>

<script>
function konfirmasiLogin(loginUrl) {
    if (confirm("Anda harus login terlebih dahulu. Login sekarang?")) {
        window.location.href = loginUrl;
    }
}

function konfirmasiLogout(urlLogout) {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        window.location.href = urlLogout;
    }
}
</script>

</body>
</html>