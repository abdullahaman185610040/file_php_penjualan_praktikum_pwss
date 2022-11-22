<?php
$barang_pilih= 0 ;
if(isset($_COOKIE['keranjang'])){
    $barang_pilih = $_COOKIE['keranjang'];
}
if(isset($_GET['idbarang'])){
    $idbarang = $_GET['idbarang'];
    $barang_pilih = $barang_pilih .",". $idbarang;
    setcookie('keranjang',$barang_pilih,time()+3600);
}
include "koneksi.php";
$sql = "select * from barang where idbarang not in (".$barang_pilih.")
        and stok > 0 order by idbarang desc ";

$hasil = mysqli_query($kon, $sql);
if(!$hasil)
    die("Gagal Query..".mysqli_error());
?>
<h2> DAFTAR BARANG TERSEDIA </h2>
<table border="1">
    <tr>
    <th>Foto</th>
    <th>Nama Barang</th>
    <th>Harga Jual</th>
    <th>Stok</th>
    <th>Operasi</th>
    </tr>
    <?php
        $no = 0;
        while($row = mysqli_fetch_assoc($hasil)){
            echo " <tr> ";
            echo " <td> <a href='pict/{$row['foto']} ' />
                <img src='thumb/t_{$row['foto']} ' width='100' />
                </a> </td> ";
            echo " <td> ".$row['nama']."</td> ";
            echo " <td> ".$row['harga']."</td> ";
            echo " <td> ".$row['stok']."</td> ";
            echo " <td> ";
            echo " <a href ='".$_SERVER['PHP_SELF']."?idbarang=".$row['idbarang']."'> BELI <a/>";
            echo " </td> ";
            echo " </tr> ";
        }
    ?>
</table>