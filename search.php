<?php
	
	require_once "class/db_koneksi.php";
	require_once "class/User.php";
	require_once "class/Produk.php";

	$user = new User($db);
	$dataUser = $user->getUser();

	$produk = new Produk($db);

?>

<?php
	include "header.php";
?>
<!-- products-breadcrumb -->
<div class="products-breadcrumb">
	<div class="container">
		<ul>
			<li><i class="fa fa-home" aria-hidden="true"></i><a href="index.php">Beranda</a><span>|</span></li>
			<li>Hasil Pencarian</li>
		</ul>
	</div>
</div>
<!-- //products-breadcrumb -->
<!-- top-brands -->
	<div class="top-brands">
		<div class="container">
			<div class="agile_top_brands_grids">
				<h3><span>Hasil Pencarian</span></h3>
	             <table class="table table-striped">
	                <thead></thead>
	                <tbody>
	                    <?php

	                        if(isset($_GET['search'])){

                    			$search = $_GET['search'];

	                            $query = "SELECT * FROM tbl_produk WHERE nama_produk LIKE '%{$search}%' AND stok > 0";

	                            $records_per_page=8;
	                            $newquery = $produk->paging($query,$records_per_page);
	                            $produk->indexProduk($newquery);

	                        }
	                        
	                     ?>
	                     <tr>
	                        <td colspan="7" align="center">
	                            <div class="pagination-wrap">
	                            <?php $produk->paginglink($query,$records_per_page); ?>
	                            </div>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //top-brands -->
<?php
	
	include "footer.php";

?>