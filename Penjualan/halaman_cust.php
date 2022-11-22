<?php
session_start();
if(!isset($_SESSION["user"])){
    echo "Sesi Sudah Habis!<br/>
        <a href = 'login_form.php'>LOGIN LAGI</a>";
    exit;
}
echo "SELAMAT DATANG<br/>";
echo "USER  : ".$_SESSION["user"]."<br/>";
echo "NAMA  : ".$_SESSION["nama_lengkap"]."<br/>";
?>
<hr/>
<div id = "menu">
    <h2>LINK</h2>
    <a href = "barang_tersedia.php">Barang Tersedia</a> <br/>
    <a href = "keranjang_belanja.php">Keranjang Belanja</a> <br/>
    <a href = "login_form.php">Logout</a> <br/>
</div>