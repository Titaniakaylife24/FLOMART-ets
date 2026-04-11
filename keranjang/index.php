<?php
include '../cek_login.php';
include '../koneksi/koneksi.php';

harusLogin();

$id_user = $_SESSION['id_user'];

/* DATA USER */
$userQuery = mysqli_query($conn, "
SELECT nama, no_hp, alamat 
FROM users 
WHERE id_user = $id_user
");

$user = mysqli_fetch_assoc($userQuery);

/* DATA KERANJANG */
$query = "
SELECT 
    keranjang.id_keranjang,
    keranjang.jumlah,
    produk.nama_produk,
    produk.harga,
    produk.gambar
FROM keranjang
JOIN produk ON keranjang.id_produk = produk.id_produk
WHERE keranjang.id_user = $id_user
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Keranjang</title>
<link rel="stylesheet" href="/FLOMART-ets/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto p-6">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Keranjang Saya</h1>
    <a href="../user/dashboard.php" class="text-green-600 hover:underline">
        ← Kembali
    </a>
</div>

<?php if (mysqli_num_rows($result) == 0): ?>

<div class="bg-white p-10 rounded-xl shadow text-center text-gray-500">
    Keranjang kosong 😢
</div>

<?php else: ?>

<form action="../user/checkout.php" method="POST">

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<!-- LIST PRODUK -->
<div class="lg:col-span-2 space-y-4">

<?php while($row = mysqli_fetch_assoc($result)): 
$totalItem = $row['harga'] * $row['jumlah'];

$gambar = !empty($row['gambar']) 
    ? "/FLOMART-ets/uploads/produk/" . basename($row['gambar'])
    : "/FLOMART-ets/assets/img/no-image.png";
?>

<div class="bg-white rounded-xl shadow p-4 flex items-center justify-between hover:shadow-md transition">

<div class="flex items-center gap-4 flex-1">

<input type="checkbox"
    class="item-check w-5 h-5 accent-green-600"
    name="selected_items[]"
    value="<?= $row['id_keranjang']; ?>"
    data-total="<?= $totalItem ?>">

<img src="<?= $gambar; ?>"
    class="w-20 h-20 object-cover rounded-lg border">

<div>
    <p class="font-semibold text-gray-800 text-lg">
        <?= htmlspecialchars($row['nama_produk']); ?>
    </p>

    <p class="text-sm text-gray-500">
        Rp <?= number_format($row['harga']); ?>
    </p>

    <p class="text-green-600 font-semibold">
        Total: Rp <?= number_format($totalItem); ?>
    </p>
</div>

</div>

<!-- QTY -->
<div class="flex items-center gap-2">

<button type="button"
onclick="updateQty(<?= $row['id_keranjang']; ?>,'kurang')"
class="w-9 h-9 bg-gray-200 rounded-full">-</button>

<span class="font-semibold">
<?= $row['jumlah']; ?>
</span>

<button type="button"
onclick="updateQty(<?= $row['id_keranjang']; ?>,'tambah')"
class="w-9 h-9 bg-gray-200 rounded-full">+</button>

</div>

<!-- DELETE -->
<button type="button"
onclick="hapusItem(<?= $row['id_keranjang']; ?>)"
class="text-gray-400 hover:text-red-500 text-xl ml-3">
🗑️
</button>

</div>

<?php endwhile; ?>

</div>

<!-- RINGKASAN -->
<div class="bg-white p-6 rounded-xl shadow-lg h-fit sticky top-6">

<h2 class="text-xl font-bold mb-4">Ringkasan Belanja</h2>

<div class="bg-gray-50 p-4 rounded-lg mb-4 space-y-3">

<div>
<label>Nama</label>
<input type="text" name="nama"
value="<?= htmlspecialchars($user['nama']); ?>"
class="w-full border p-2 rounded">

<div>
<label>No HP</label>
<input type="text" name="no_hp"
value="<?= htmlspecialchars($user['no_hp']); ?>"
class="w-full border p-2 rounded">
</div>

<div>
<label>Alamat</label>
<textarea name="alamat" required
class="w-full border p-2 rounded"><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
</div>

<div>
<label>Wilayah</label>
<select name="ongkir" id="ongkir"
class="w-full border p-2 rounded">
<option value="0">Pilih Wilayah</option>
<option value="10000">Surabaya</option>
<option value="12000">Sidoarjo</option>
<option value="15000">Jakarta</option>
</select>
</div>

<div>
<label>Catatan</label>
<textarea name="catatan"
class="border p-2 w-full rounded"
placeholder="Contoh: kirim sore hari"></textarea>
</div>

<div>
<label>Metode Pembayaran</label>
<select name="metode" class="w-full border p-2 rounded">
<option value="COD">COD</option>
<option value="Transfer">Transfer</option>
</select>
</div>

</div>

<p>Subtotal: <span id="subtotal">Rp 0</span></p>
<p>Ongkir: <span id="ongkirText">Rp 0</span></p>

<hr class="my-2">

<p class="font-bold">
Total: <span id="total">Rp 0</span>
</p>

<button onclick="return validasi()"
class="w-full mt-4 bg-green-600 text-white py-3 rounded">
Checkout
</button>

</div>

</div>

</form>

<?php endif; ?>

</div>

<script>
function hitungTotal(){
let subtotal = 0;

document.querySelectorAll('.item-check:checked').forEach(cb=>{
subtotal += parseInt(cb.dataset.total);
});

let ongkir = parseInt(document.getElementById('ongkir').value);
let total = subtotal + ongkir;

document.getElementById('subtotal').innerText = "Rp "+subtotal.toLocaleString();
document.getElementById('ongkirText').innerText = "Rp "+ongkir.toLocaleString();
document.getElementById('total').innerText = "Rp "+total.toLocaleString();
}

document.querySelectorAll('.item-check').forEach(cb=>{
cb.addEventListener('change', hitungTotal);
});

document.getElementById('ongkir').addEventListener('change', hitungTotal);

window.onload = hitungTotal;

function validasi(){
if(document.querySelectorAll('.item-check:checked').length == 0){
alert("Pilih produk dulu!");
return false;
}

if(document.getElementById('ongkir').value == 0){
alert("Pilih wilayah dulu!");
return false;
}

return true;
}

function updateQty(id, aksi){
fetch('update_qty.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:'id='+id+'&aksi='+aksi
}).then(()=>location.reload());
}

function hapusItem(id){
if(!confirm('Hapus item?')) return;

fetch('hapus.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:'id='+id
}).then(()=>location.reload());
}
</script>

</body>
</html>