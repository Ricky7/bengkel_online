<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";
  require_once "../class/Produk.php";

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
    <li role="presentation"><a href="admin_order_pending.php">Menunggu</a></li>
    <li role="presentation" class="active"><a href="#">Dibayar</a></li>
    <li role="presentation"><a href="admin_order_sent.php">Dikirim</a></li>
    <li role="presentation"><a href="admin_order_finish.php">Selesai</a></li>
  </ul>

  <div class="row">
    <div class="col-md-12">
      <h4 align="center">Pesanan yang lunas</h4>
      <table class="table table-bordered" style="text-align:center;">
        <thead>
          <th style="text-align:center;">ID Order</th>
          <th style="text-align:center;">Tanggal Pesanan</th>
          <th style="text-align:center;">Dikirim Ke</th>
          <th style="text-align:center;">Total Biaya</th>
          <th style="text-align:center;">Aksi</th>
        </thead>
        <tbody>
          <?php
            $query = "SELECT * FROM tbl_order WHERE status_order='Bayar' ORDER BY tgl_order DESC";       
            $records_per_page=10;
            $newquery = $produk->paging($query,$records_per_page);
            $produk->listOrder($newquery);
           ?>
           <tr>
                <td colspan="8" align="center">
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