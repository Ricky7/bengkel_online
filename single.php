<?php
	
	require_once "class/db_koneksi.php";
	require_once "class/User.php";
	require_once "class/Produk.php";

	$user = new User($db);
	$dataUser = $user->getUser();

	$produk = new Produk($db);

    if(isset($_REQUEST['item_id']))
    {
       $id = $_REQUEST['item_id'];
       extract($produk->getProdukID($id));
       extract($produk->getKategoriID($id_kategori));
    }

    // format mata uang
    $jumlah_desimal = "0";
    $pemisah_desimal = ",";
    $pemisah_ribuan = ".";

    if(isset($_POST['submit'])) {

    	if($user->isUserLoggedIn()){
	        
	        $total_harga = $_POST['harga'] * $_POST['jumlah'];
	 		try {
		    	$produk->addCart(array(
		    		'id_produk' => $_POST['id_produk'],
		    		'id_user' => $_POST['id_user'],
		    		'harga' => $total_harga,
		    		'jumlah' => $_POST['jumlah']
		    	));
		    	//header("refresh:0");
		    	header("location: cart.php");
		    } catch (Exception $e) {
				die($e->getMessage());
			}
	    } else {
	    	header("location: login.php");
	    }	
 	}

?>

<?php
	include "header.php";
?>
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
	<div class="container">
		<ul>
			<li><i class="fa fa-home" aria-hidden="true"></i><a href="index.php">Beranda</a><span>|</span></li>
			<li>Info Produk</li>
		</ul>
	</div>
</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
	<?php
		include "sidebar.php";
	?>
	<div class="w3l_banner_nav_right">
		<div class="agileinfo_single">
			<h5 align="center"><?php echo $nama_produk ?></h5>
			<div class="col-md-4 agileinfo_single_left">
				<img id="example" src="assets/image_produk/<?php echo $gambar ?>" alt=" " class="img-responsive" />
			</div>
			<div class="col-md-8 agileinfo_single_right">
				<div class="w3agile_description">
					<h4>Kode Produk :</h4>
					<p><?php echo $kode_produk ?></p>
					<h4>Description :</h4>
					<p><?php echo $deskripsi ?></p>
				</div>
				<div class="w3agile_description">
					<h4>Kategori :</h4>
					<p><?php echo $nama_kategori ?></p>
					<h4>Merk :</h4>
					<p><?php echo $merk ?></p>
					<h4>Stok :</h4>
					<p><font color="red"><?php echo $stok ?></font></p>
					<form method="post">
					<input min="1" style="width:5em" class="form-control" type="number" name="jumlah" max="<?php echo $stok ?>" value="1">
				</div>
				<div class="snipcart-item block">
					<div class="snipcart-thumb agileinfo_single_right_snipcart">
						<h4><?php print("Rp. ".number_format($harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></h4>
					</div>
					<div class="snipcart-details agileinfo_single_right_details">
						<form method="post">
							<fieldset>
								<input type="hidden" value="<?php echo $id_produk ?>" name="id_produk">
								<input type="hidden" value="<?php echo $dataUser['id_user'] ?>" name="id_user">
								<input type="hidden" value="<?php echo $harga; ?>" name="harga">
								<?php
									if($stok <= 0) {
										?>
											<h4><font color="red">Stok Habisss!!!</font></h4>
										<?php
									} else {
										?>
											<input type="submit" name="submit" value="Beli" class="button" />
										<?php
									}
								?>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<!-- banner -->



<?php
	
	include "footer.php";

?>