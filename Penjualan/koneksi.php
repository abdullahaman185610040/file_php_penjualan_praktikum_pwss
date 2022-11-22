<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$host   =   "localhost";
$user   =   "root";
$pass   =   "";
$dbName =   "toko_ol";

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
$sqlTabelBarang = "create table if not exists barang(
    idbarang int auto_increment not null primary key,
    nama varchar(40) not null,
    harga int not null default 0,
    stok int not null default 0,
    foto varchar(70) not null default' ',
    KEY(nama) )";

mysqli_query($kon, $sqlTabelBarang) or die ("Gagal Buat Tabel Barang");


$sqlTabelHjual = "create table if not exists hjual (
                    idhjual int auto_increment not null primary key, 
                    tanggal date not null,
                    namacust varchar(40) not null,
                    email varchar(40) not null default'',
                    notelp varchar(70) not null default ''
                )";

mysqli_query($kon, $sqlTabelHjual) or die ("Gagal Buat Tabel Header Jual");

$sqlTabelDjual = "create table if not exists djual (
    iddjual int auto_increment not null primary key, 
    idhjual int not null,
    idbarang int not null,
    qty int not null ,
    harga int not null 
)";
mysqli_query($kon, $sqlTabelDjual) or die ("Gagal Buat Tabel Detail Jual");

$sqlTabelUser = "create table if not exists pengguna(
                idpengguna int auto_increment not null primary key,
                user varchar(25) not null,
                password varchar(50) not null,
                nama_lengkap varchar(50) not null,
                akses varchar(10) not null)";

mysqli_query ($kon, $sqlTabelUser) or die("Gagal Buat Tabel Pengguna");

$sql = "select * from pengguna";
$hasil = mysqli_query($kon, $sql);
$jumlah = mysqli_num_rows($hasil);
if($jumlah==0){
    $sql = "insert into pengguna (user, password, nama_lengkap, akses)
            values ('admin', md5('admin'),'administrator','toko'),
                    ('cust', md5('cust'), 'pelanggan', 'beli')";
    mysqli_query($kon, $sql);
}
echo "Tabel Siap<hr/>";
?>