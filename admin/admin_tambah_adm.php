<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";

  $admin = new Admin($db);

  $roles = $admin->getAdmin();

  $admin->cekLogin();

  if(isset($_POST['submit'])) {

        try {
          $admin->tambahAdmin(array(
            'nama' => $_POST['nama'],
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'peran' => 'admin'
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
    <li role="presentation"><a href="admin_data_adm.php">Daftar</a></li>
    <li role="presentation" class="active"><a href="#">Tambah</a></li>
    <li role="presentation"><a href="admin_ubah_pass.php">Ubah Password</a></li>
  </ul>

  <div class="row">
    <div class="col-md-4">
      <form method="post">
        <h4 align="center">Tambah Admin</h4>
        <div class="input-group" style="padding-top:10px;">
          <span class="input-group-addon" id="basic-addon1">@</span>
          <input type="text" name="nama" class="form-control" placeholder="Nama" aria-describedby="basic-addon1">
        </div>
        <div class="input-group" style="padding-top:10px;">
          <span class="input-group-addon" id="basic-addon1">@</span>
          <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group" style="padding-top:10px;padding-bottom:10px;">
          <span class="input-group-addon" id="basic-addon1">@</span>
          <input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
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