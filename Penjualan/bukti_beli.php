<style type ="text/css">
@media print{
    #tombol{
        display: none;
    }
}
</style>
<div id="tombol">
    <input type="button" value="Beli Lagi"
        oneclick="window.location.assign('barang_tersedia.php')">
    <input type = "button" value="Print"
        oneclick="window.print()">
</div>
<?php
     $idhjual = $_GET["idhjual"];
     include "koneksi.php";
     $sqlhjual = "select * from hjual where idhjual = $idhjual";
     $hasilhjual = mysqli_query($kon, $sqlhjual);
     $rowhjual = mysqli_fetch_assoc($hasilhjual);

     echo "<pre>";
     echo "<h2>BUKTI PEMBELIAN</h2>";
     echo "No. Nota : ".date("Ymd").$rowhjual['idhjual']."<br/>";
     echo "TANGGAL  : ".$rowhjual['tanggal']."<br/>";
     echo "NAMA     : ".$rowhjual['namacust']."<br/>";
     $sqlidjual = "select barang.nama, djual.harga, djual.qty,
                    (djual.harga * djual.qty) as jumlah 
                    from djual inner join barang
                    on djual.idbarang = barang.idbarang
                    where djual.idhjual = $idhjual";
    $hasildjual = mysqli_query($kon, $sqlidjual);
    echo "<table border ='1' cellingpadding='10' cellspacing='0'>";
    echo "<tr>";
    echo "<th> Nama Barang </th>";
    echo "<th> Quantity </th>";
    echo "<th> Harga </th>";
    echo "<th> Jumlah </th>";
    echo "</tr>";
    $totalharga= 0;
    while($rowdjual= mysqli_fetch_assoc($hasildjual)){
        echo "<tr>";
        echo "<td>".$rowdjual['nama']."</td>";
        echo "<td align='right'>".$rowdjual['qty']."</td>";
        echo "<td align='right'>".$rowdjual['harga']."</td>";
        echo "<td align='right'>".$rowdjual['jumlah']."</td>";
        echo "</tr>";
        $totalharga = $totalharga + $rowdjual['jumlah'];
    }
    echo "<tr>";
    echo "<td colspan='3' align='right'>";
    echo "      <strong>Total Jumlah</strong> </td>";
    echo "<td align='right'><strong>$totalharga</strong> </td>";
    echo "</tr>"; 
    echo "</table>";
    echo "</pre>"; 
?>