<?php
	
	require_once "class/db_koneksi.php";
	require_once "class/User.php";
	require_once "class/Produk.php";

	$user = new User($db);

	$produk = new Produk($db);

?>

<?php
	include "header.php";
?>
<!-- banner -->
<div class="banner">
	<?php
		include "sidebar.php";
		include "slideshow.php";
	?>
	<div class="clearfix"></div>
</div>
<!-- banner -->
	
<!-- top-brands -->
	<div class="top-brands">
		<div class="container">
			<div class="agile_top_brands_grids">
	             <table class="table table-striped">
	                <thead></thead>
	                <tbody>
	                    <?php

	                        if(isset($_GET['kategori']) && !empty($_GET['kategori'])) {

	                            $kategori = $_GET['kategori'];

	                            $query = "SELECT * FROM tbl_produk INNER JOIN tbl_kategori ON (tbl_produk.id_kategori=tbl_kategori.id_kategori) WHERE tbl_kategori.nama_kategori='$kategori' AND tbl_produk.stok > 0";

	                            $records_per_page=8;
	                            $newquery = $produk->paging($query,$records_per_page);
	                            $produk->indexProduk($newquery);

	                        } else {
	                            $query = "SELECT * FROM tbl_produk";       
	                            $records_per_page=9;
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


