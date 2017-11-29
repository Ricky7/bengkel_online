<?php
	
	require_once "class/db_koneksi.php";
	require_once "class/User.php";
	require_once "class/Produk.php";

	$user = new User($db);
	$dataUser = $user->getUser();

	$produk = new Produk($db);

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
			<li>Belanjaanku</li>
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
			<h3><span>Belanjaanku</span></h3>
			<ul class="nav nav-tabs">
			    <li role="presentation"><a href="belanjaanku.php">Belum Bayar</a></li>
			    <li role="presentation"><a href="belanjaanku_tunggu.php">Menunggu</a></li>
			    <li role="presentation" class="active"><a href="#">Proses</a></li>
			    <li role="presentation"><a href="belanjaanku_dikirim.php">Dikirim</a></li>
			    <li role="presentation"><a href="belanjaanku_selesai.php">Selesai</a></li>
			 </ul>
			 <div class="checkout-right">
			 	<h4>Pembayaran telah diterima petugas</h4>
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>ID Order</th>	
							<th>Tanggal Pesanan</th>
							<th>Total Biaya</th>
							<th>Keterangan</th>
							<th>Opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = "SELECT *, SUM(tbl_order_detail.harga) as xharga FROM tbl_order INNER JOIN tbl_order_detail ON (tbl_order.id_order=tbl_order_detail.id_order) 
							WHERE tbl_order.id_user={$dataUser['id_user']} AND tbl_order.status_order='Bayar' GROUP BY tbl_order.id_order";       
							$records_per_page=10;
							$newquery = $produk->paging($query,$records_per_page);
							$produk->waitOrder($newquery);
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
		<!-- //about -->
	</div>
	<div class="clearfix"></div>
</div>
<!-- banner -->



<?php
	
	include "footer.php";

?>