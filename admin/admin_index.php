<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";

  $admin = new Admin($db);

  $roles = $admin->getAdmin();

  $admin->cekLogin();

?>

<?php

	include "admin_header.php";

?>
<div class="container">
	<div class="row" style="padding-top:30px;padding-bottom:30px;">
		<div class="col-md-4">
			<center>
				<a href="admin_data_produk.php"><img src="../assets/images/list-icon.png" class="img-responsive" width="200px" height="200px"></a>
			</center>
		</div>
		<div class="col-md-4">
			<center>
				<a href="admin_order_pending.php"><img src="../assets/images/cart-icon.png" class="img-responsive" width="200px" height="200px"></a>
			</center>
		</div>
		<div class="col-md-4">
			<center>
				<a href="admin_data_adm.php"><img src="../assets/images/admin-tool.png" class="img-responsive" width="200px" height="200px"></a>
			</center>
		</div>
		
	</div>
<div>
<?php

	include "admin_footer.php";

?>