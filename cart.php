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

    if(!$user->isUserLoggedIn()){
    	header("location: login.php");
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
			<li>Keranjang Belanja</li>
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
			<h3><span>Keranjang Belanja</span></h3>
			
	      <div class="checkout-right">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>Kode</th>	
							<th>Produk</th>
							<th>Nama Produk</th>
							<th>Jumlah</th>
							<th>Harga</th>
							<th>Hapus</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = "SELECT * FROM tbl_cart INNER JOIN tbl_produk ON (tbl_cart.id_produk=tbl_produk.id_produk) WHERE tbl_cart.id_user={$dataUser['id_user']}";       
							$records_per_page=10;
							$newquery = $produk->paging($query,$records_per_page);
							$produk->dataCart($newquery);
						 ?>
                     <tr>
                        <td colspan="6" align="center">
                            <div class="pagination-wrap">
                            <?php $produk->paginglink($query,$records_per_page); ?>
                            </div>
                        </td>
                    </tr>
					</tbody>
				</table>
			</div>
			<div class="checkout-left">
				<div class="col-md-4 checkout-left-basket">
					<a href="index.php"><h4>Lanjut Belanja</h4></a>
				</div>
				<div class="col-md-8 address_form_agile">	
					<div class="checkout-right-basket">
				        <a href="order.php">Lanjut Pemesanan <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
			      	</div>
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