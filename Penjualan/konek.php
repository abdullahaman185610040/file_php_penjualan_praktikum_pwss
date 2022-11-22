<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$host   =   "localhost";
$user   =   "root";
$pass   =   "";
$dbName =   "sewabuku";

$kon = mysqli_connect($host,$user,$pass);
if(!$kon)
    die("Gagal Koneksi...");

$hasil = mysqli_select_db($kon,$dbName);
if (!$hasil){
    $hasil = mysqli_query($kon, "CREATE DATABASE $dbName");
    if(!$hasil)
        die ("Gagal Buat Database");
    
    else
        $hasil = mysqli_select_db($kon,$dbName);
        if(!$hasil) die ("Gagal Konek Database");
}
$sqlTabelBuku = "create table if not exists buku(
    idbuku int(11) auto_increment not null primary key,
    kode varchar(10) not null,
    judul varchar(40) not null,
    pengarang varchar(40) not null,
    penerbit varchar(40) not null,
    stok int(11) not null default 0,
    foto varchar(70) not null default' ',
    KEY(judul) )";

mysqli_query($kon, $sqlTabelBuku) or die ("Gagal Buat Tabel Buku");
?>