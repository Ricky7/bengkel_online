<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";
  require_once "../class/Produk.php";

  $admin = new Admin($db);
  $produk = new Produk($db);

  $roles = $admin->getAdmin();

  $admin->cekLogin();

  if(isset($_POST['submit'])) {

        try {
          $produk->tambahKategori(array(
            'nama_kategori' => $_POST['nama_kat'],
            'deskripsi_kat' => $_POST['desk_kat']
          ));
          //header("location: my_order.php");
        } catch (Exception $e) {
        die($e->getMessage());
        }
    }
?>

<?php

  include "admin_header.php";

?>
<div class="container">
  <ul class="nav nav-tabs">
    <li role="presentation"><a href="admin_data_kat.php">Daftar Kategori</a></li>
    <li role="presentation" class="active"><a href="#">Tambah Kategori</a></li>
  </ul>

  <div class="row">
    <div class="col-md-4">
      <form method="post">
        <h4 align="center">Tambah Kategori</h4>
        <div class="form-group" style="padding-top:10px;">
          <input type="text" name="nama_kat" class="form-control" placeholder="Nama Kategori" aria-describedby="basic-addon1" required>
        </div>
        <div class="form-group" style="padding-top:10px;padding-bottom:10px;">
          <textarea name="desk_kat" class="form-control" Placeholder="Deskripsi Kategori" required></textarea>
        </div>
        <center>
          <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
        </center>
      </form>
    </div>
  </div>
<div>
<?php

  include "admin_footer.php";

?>