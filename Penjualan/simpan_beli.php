<?php
$namacust   = $_POST['namacust'];
$email      = $_POST['email'];
$notelp     = $_POST['notelp'];
$tanggal    = date("Y-m-d");
$barang_pilih   = '';
$qty    = 1 ;

$dataValid = "YA";
if (strlen(trim($namacust))== 0 ){
    echo "Nama Harus Di isi.. <br/>";
    $dataValid = "TIDAK";
}
if (strlen(trim($notelp))== 0 ){
    echo "No. Telp Harus Di isi.. <br/>";
    $dataValid = "TIDAK";
}
if(isset($_COOKIE['keranjang'])){
    $barang_pilih = $_COOKIE['keranjang'];
}else{
    echo "Keranjang Tidak Boleh Kosong <br/>";
    $dataValid = "Tidak";
}
if ($dataValid == "Tidak"){
    echo "Masih Ada Kesalahan, Silahkan Perbaiki! <br/>";
    echo "<input type = 'button' value = 'Kembali'
        onClick='self.history.back()'>"; 
    exit;
}

include "koneksi.php";

$simpan = true;
$mulai_transaksi = mysqli_begin_transaction($kon);

$sql = "insert into hjual (tanggal, namacust, email, notelp)
        values ('$tanggal', '$namacust', '$email', '$notelp')";
$hasil = mysqli_query($kon, $sql);
if(!$hasil){
    echo "Data Customer Gagal Disimpan ! <br/>";
    $simpan = false;
}

$idhjual = mysqli_insert_id($kon);
if($idhjual==0){
    echo "Data Customer Tidak Ada <br/> ";
    $simpan = false;
}

$barang_array = explode(",",$barang_pilih);
$jumlah = count($barang_array);
if ($jumlah <= 1){
    echo "Tidak Ada Barang yang Dipilih <br/>";
    $simpan = false;
}else{
    foreach($barang_array as $idbarang){
        if ($idbarang == 0){
            continue;
        }
        $sql = "select * from barang where idbarang = $idbarang ";
        $hasil = mysqli_query($kon, $sql);
        if(!$hasil){
            echo "Barang Tidak Ada <br/>";
            $simpan = false;
            break;
        }else{
            $row = mysqli_fetch_assoc($hasil);
            $stok = $row['stok']-1;
            if($stok<0){
                echo "Stok Barang ".row['nama']." Kosong <br/>";
                $simpan = false;
                break;
            }
            $harga = $row ['harga'];
        }
        $sql ="insert into djual (idhjual, idbarang, qty, harga)
                values ('$idhjual','$idbarang','$qty','$harga')";
        $hasil = mysqli_query($kon, $sql);
        if (!$hasil){
            echo "Detail Jual Gagal simpan <br/>";
            $simpan = false;
            break;
        }
        $sql = "update barang set stok = $stok
            where idbarang = $idbarang";
        $hasil = mysqli_query($kon, $sql);
        if(!$hasil){
            echo "Update Stok Barang Gagal <br/>";
            $simpan = false;
            break;
        }
    }
}

if ($simpan){
    $komit = mysqli_rollback($kon);
}else{
    $rollback = mysqli_rollback($kon);
    echo "Pembelian Gagal <br/> 
        <input type = 'button' value = 'Kembali'
        onClick='self.history.back()'>";
        exit;
}
header ("Location: bukti_beli.php? idhjual=$idhjual");
setcookie('keranjang',$barang_pilih,time()-3600);
?>