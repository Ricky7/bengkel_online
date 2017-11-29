<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";

  $admin = new Admin($db);

  $roles = $admin->getAdmin();
  $id_admin = $roles['id_admin'];

  $admin->cekLogin();

?>

<?php

  include "admin_header.php";

?>
<div class="container">
  <ul class="nav nav-tabs">
    <li role="presentation"><a href="admin_data_adm.php">Daftar</a></li>
    <li role="presentation"><a href="admin_tambah_adm.php">Tambah</a></li>
    <li role="presentation" class="active"><a href="#">Ubah Password</a></li>
  </ul>

  <div class="row">
    <div class="col-md-4">
      <form method="post">
        <h4 align="center">Ubah Password</h4>
        <?php

          if(isset($_POST['submit'])) {
  
              try {
                  $admin->ubahPassword($id_admin, $_POST['pass_lama'], $_POST['pass_baru']);
                  //header("location: ubah_password.php?changed");
                } catch (Exception $e) {
                  //die($e->getMessage());

                }
            }

        ?>
        <div class="input-group" style="padding-top:10px;">
          <span class="input-group-addon" id="basic-addon1">@</span>
          <input type="password" name="pass_lama" class="form-control" placeholder="Password Lama" aria-describedby="basic-addon1">
        </div>

        <div class="input-group" style="padding-top:10px;padding-bottom:10px;">
          <span class="input-group-addon" id="basic-addon1">@</span>
          <input type="password" name="pass_baru" class="form-control" placeholder="Password Baru" aria-describedby="basic-addon1">
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