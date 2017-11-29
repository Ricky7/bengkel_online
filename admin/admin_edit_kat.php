<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";
  require_once "../class/Produk.php";

  $admin = new Admin($db);
  $produk = new Produk($db);

  $roles = $admin->getAdmin();

  if(isset($_REQUEST['id']))
  {
      $id = $_REQUEST['id'];
      extract($produk->getKategoriID($id)); 
  }

  $admin->cekLogin();

  if(isset($_POST['submit'])) {

        try {
          $produk->updateKategori(array(
            'nama_kategori' => $_POST['nama_kat'],
            'deskripsi_kat' => $_POST['desk_kat']
          ), $id);
          header("location: admin_data_kat.php");
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
    <li role="presentation"><a href="admin_tambah_kat.php">Tambah Kategori</a></li>
    <li role="presentation" class="active"><a href="#">Tambah Kategori</a></li>
  </ul>

  <div class="row">
    <div class="col-md-4">
      <form method="post">
        <h4 align="center">Tambah Kategori</h4>
        <div class="form-group" style="padding-top:10px;">
          <input type="text" name="nama_kat" class="form-control" placeholder="Nama Kategori" aria-describedby="basic-addon1" value="<?php echo $nama_kategori; ?>" required>
        </div>
        <div class="form-group" style="padding-top:10px;padding-bottom:10px;">
          <textarea name="desk_kat" class="form-control" Placeholder="Deskripsi Kategori" required> <?php echo $deskripsi_kat; ?> </textarea>
        </div>
        <center>
          <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
        </center>
      </form>
    </div>
  </div>
<div>
<?php

  include "admin_footer.php";

?>