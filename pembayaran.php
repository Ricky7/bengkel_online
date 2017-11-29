<?php
	
	error_reporting(0);
	require_once "class/db_koneksi.php";
	require_once "class/User.php";
	require_once "class/Produk.php";

	$user = new User($db);
	$dataUser = $user->getUser();

	$produk = new Produk($db);

    if(!$user->isUserLoggedIn()){
    	header("location: login.php");
    }

    if(isset($_REQUEST['slug'])) {

    	$id_order = $_REQUEST['slug'];
    }

    if(isset($_POST['submit'])) {

    	$imgFile = $_FILES['bukti']['name'];
        $tmp_dir = $_FILES['bukti']['tmp_name'];
        $imgSize = $_FILES['bukti']['size'];


        if(empty($imgFile)) {
            $errMsg = "Please select image File..";
        } else {
            $upload_dir = 'assets/img_bukti/'; // upload directory
 
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
          
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
          
            // rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;

            // allow valid image file formats
            if(in_array($imgExt, $valid_extensions)){   
                // Check file size '5MB'
                if($imgSize < 5000000)    {
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                } else {
                    $errMSG = "Sorry, your file is too large.";
                }
            } else {
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
            }
        }

    	if(!isset($errMsg)) {
	        try {
	          $produk->insertBayar(array(
	            'jenis_bank' => $_POST['jenis_bank'],
	            'nama_rek' => $_POST['nama_rek'],
	            'no_rek' => $_POST['no_rek'],
	            'nilai_transfer' => $_POST['nilai_transfer'],
	            'ket_transfer' => $_POST['ket_transfer'],
	            'bukti' => $userpic,
	            'status_order' => 'Tunggu'
	          ), $dataUser['id_user'], $id_order);
	          header("location: index.php");
	        } catch (Exception $e) {
	        die($e->getMessage());
	        }
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
			<li>Pembayaran</li>
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
		<!-- about -->
		<div class="privacy about">
			<h3><span>Pembayaran</span></h3>
			<div class="checkout-left">	
				<div class="col-md-6 checkout-left-basket">
					<h4>Informasi Pengiriman</h4>
					<ul>
						<?php
							$jumlah_desimal = "0";
					        $pemisah_desimal = ",";
					        $pemisah_ribuan = ".";

							$data = $produk->getOrderData($id_order);
							$ttlHarga = $produk->getTotalHarga($id_order);
						?>
						<li>Alamat <span><?php echo $data['alamat'] ?></span></li>
						<li>No Handphone <span><?php echo $data['no_hp'] ?></span></li>
						<li>Tanggal Pesan <span><?php echo $data['tgl_order'] ?></span></li>
						<li>Deskripsi <span><?php echo $data['desk_order'] ?></span></li>
						<li>Kurir Antar <span><?php echo $data['jasa_kurir'] ?></span></li>
						<li>Paket Antar <span><?php echo $data['jenis_paket'] ?></span></li>
						<li>Berat <span><?php echo $data['berat_order'] ?> gr</span></li>
						<li>Total Belanja <span><?php echo "Rp. ".number_format($ttlHarga['xtotal'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span></li>
						<li>Ongkos Kirim <span><?php echo "Rp. ".number_format($data['ongkir'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span></li>
						<li><b>Total Biaya yang harus ditransfer <span><?php echo "Rp. ".number_format($data['ongkir']+$ttlHarga['xtotal'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span></b></li>
					</ul>
					<br>
					<h4>Belanjaan Anda</h4>
					<ul>
						<?php
							$produk->myOrder($id_order);
						?>
					</ul>
					</br>
					<h4>Informasi Transfer</h4>
					<ul>
						<li>Irfan Putra Jaya <span>(MANDIRI) 756749566</span></li>
						<li>Irfan Putra Jaya <span>(BCA) 657846587</span></li>
						<li>Irfan Putra Jaya <span>(BNI) 307469865</span></li>
						<li>Irfan Putra Jaya <span>(BRI) 579375639</span></li>
					</ul>
				</div>
				<div class="col-md-6 address_form_agile">
				  <h4>Form Pembayaran</h4>
					<form method="post" class="creditly-card-form agileinfo_form" enctype="multipart/form-data">
						<section class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
								<div class="first-row form-group">
									<div class="controls">
										<label class="control-label">Jenis Bank: </label>
										<select class="form-control option-w3ls" style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' name="jenis_bank" required>
							                <option></option>
							                <option value="MANDIRI">MANDIRI</option>
							                <option value="BCA">BCA</option>
							                <option value="BNI">BNI</option> 
							                <option value="BRI">BRI</option>              
							              </select>
										
									</div>

									<div class="controls">
										<label class="control-label">Nama Rekening: </label>
										<input class="billing-address-name form-control" style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' type="text" name="nama_rek" required>
									</div>
									
						            <div class="controls">
										<label class="control-label">No Rekening: </label>
										<input class="billing-address-name form-control" style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' type="text" name="no_rek" required>
										
									</div>

									<div class="controls">
										<label class="control-label">Nilai Transfer: </label>
										<input class="billing-address-name form-control" style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' type="text" value="<?php echo $data['ongkir']+$ttlHarga['xtotal'] ?>" name="nilai_transfer" readonly>
									</div>

									<div class="controls">
										<label class="control-label">Bukti Pembayaran: </label>
										<input type="file" name="bukti" class="form-control" style="min-width: 50%; margin-top: 10px; margin-bottom: 10px; padding-top: 7px; padding-bottom: 0px;" accept="image/*" required>
                            			<?php echo $errMsg; ?>
									</div>

									<div class="controls">
										<label class="control-label">Keterangan: </label>
										<textarea style="min-width: 100%;" rows="3" class="form-control" name="ket_transfer" Placeholder="Catatan Transfer bila ada..."></textarea>
									</div>

								</div>
								<button class="submit check_out" name="submit">Proses Pembayaran</button>
							</div>
						</section>
					</form>
				</div>
			
				<div class="clearfix"> </div>	
			</div>
		</div>
<!-- //about -->
	</div>
	<div class="clearfix"></div>
</div>
<!-- banner -->

<?php
	
	include "footer.php";

?>