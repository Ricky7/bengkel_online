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

<link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />

<div class="container">
  <ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="#">Daftar Kategori</a></li>
    <li role="presentation"><a href="admin_tambah_kat.php">Tambah Kategori</a></li>
  </ul>

  <div class="row">
    <div class="col-md-6">
      <h4 align="center">Daftar Kategori</h4>
      <table class="table table-bordered" style="text-align:center;">
        <thead>
          <th style="text-align:center;">#</th>
          <th style="text-align:center;">Nama Kategori</th>
          <th style="text-align:center;">Deskripsi</th>
          <th style="text-align:center;" colspan="2">Aksi</th>
        </thead>
        <tbody>
          <?php
            $query = "SELECT * FROM tbl_kategori ORDER BY id_kategori asc";       
            $records_per_page=10;
            $newquery = $produk->paging($query,$records_per_page);
            $produk->daftarKategori($newquery);
           ?>
           <tr>
                <td colspan="5" align="center">
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

  <!-- Modal Delete -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h4>
            </div>
        
            <div class="modal-body">
                <p>Apakah kamu yakin akan menghapus data ini?</p>
                <p class="debug-url"></p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <a class="btn btn-warning btn-ok">Hapus</a>
            </div>
        </div>
    </div>
</div>
<!-- diletak dibawah agar tidak bentrok -->

<script type="text/javascript">
$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    
    $('.debug-url').html('Alamat ID: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');

});
</script>
<?php

  include "admin_footer.php";

?>