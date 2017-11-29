<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";
  require_once "../class/Produk.php";

  error_reporting(0);
  
  $admin = new Admin($db);
  $produk = new Produk($db);

  $roles = $admin->getAdmin();

  $admin->cekLogin();

?>

<?php

  include "admin_header.php";

?>
<div class="container">
  <ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="#">Laporan</a></li>
  </ul>

  <div class="row">
    <div class="col-md-2">
      <form method="post" action="laporan_pdf.php">
        <h4 align="center">Input Tanggal</h4>
        <div class="form-group" style="padding-top:10px;">
          <input type="date" name="tgl_awal" class="form-control" aria-describedby="basic-addon1">
        </div>

        <div class="form-group" style="padding-top:10px;">
          <input type="date" name="tgl_akhir" class="form-control" aria-describedby="basic-addon1">
        </div>
        <center>
          <button type="submit" name="submit" class="btn btn-primary">Pdf</button>
        </center>
      </form>
    </div>

    <div class="col-md-10">
        <h4 align="center">Hasil Pencarian</h4>
        <table class="table table-bordered" style="text-align:center;">
        <thead>
          <th style="text-align:center;">Kode Barang</th>
          <th style="text-align:center;">Produk</th>
          <th style="text-align:center;">Terjual</th>
          <th style="text-align:center;">Harga</th>
        </thead>
        <tbody>
          <?php
            if($_POST['tgl_awal'] != NULL && $_POST['tgl_akhir'] != NULL) {

                $tgl_awal = $_POST['tgl_awal'];
                $tgl_akhir = $_POST['tgl_akhir'];
                $tgl = $tgl_awal.' - '.$tgl_akhir;
                $query = "SELECT tbl_produk.kode_produk, tbl_produk.nama_produk, SUM(tbl_order_detail.jumlah) as total, 
                SUM(tbl_order_detail.harga) as harga FROM tbl_order_detail INNER JOIN tbl_order INNER JOIN tbl_produk ON (tbl_order_detail.id_order = tbl_order.id_order) 
                AND (tbl_order_detail.id_produk = tbl_produk.id_produk) WHERE date(tbl_order.tgl_order) BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}' GROUP BY tbl_produk.id_produk";       
                $records_per_page=15;
                $newquery = $produk->paging($query,$records_per_page);
                $produk->Laporan($newquery);

            } else {

                $query = "SELECT tbl_produk.kode_produk, tbl_produk.nama_produk, SUM(tbl_order_detail.jumlah) as total, 
                SUM(tbl_order_detail.harga) as harga FROM tbl_order_detail INNER JOIN tbl_order INNER JOIN tbl_produk ON (tbl_order_detail.id_order = tbl_order.id_order) 
                AND (tbl_order_detail.id_produk = tbl_produk.id_produk) GROUP BY tbl_produk.id_produk";       
                $records_per_page=15;
                $newquery = $produk->paging($query,$records_per_page);
                $produk->Laporan($newquery);

            }
            
          ?>
          <tr>
            <td colspan="4" align="center">
            <div class="pagination-wrap">
              <?php $produk->paginglink($query,$records_per_page); ?>
            </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
<div>
<?php

  include "admin_footer.php";

?>