<?php
include "../class/db_koneksi.php";

// format mata uang
$jumlah_desimal = "0";
$pemisah_desimal = ",";
$pemisah_ribuan = ".";

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d H:i:s');

$tgl_awal = $_POST['tgl_awal'];
$tgl_akhir = $_POST['tgl_akhir'];


if($_POST['tgl_awal'] != NULL && $_POST['tgl_akhir'] != NULL) {

    $tgl_awal = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];
    $tgl = $tgl_awal.' - '.$tgl_akhir;
    $query = "SELECT tbl_produk.kode_produk, tbl_produk.nama_produk, SUM(tbl_order_detail.jumlah) as total, 
    SUM(tbl_order_detail.harga) as harga FROM tbl_order_detail INNER JOIN tbl_order INNER JOIN tbl_produk ON (tbl_order_detail.id_order = tbl_order.id_order) 
    AND (tbl_order_detail.id_produk = tbl_produk.id_produk) WHERE date(tbl_order.tgl_order) BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}' GROUP BY tbl_produk.id_produk";
    $stmt = $db->prepare($query);
	$stmt->execute();
} else {
	$tgl = "Keseluruhan";
    $query = "SELECT tbl_produk.kode_produk, tbl_produk.nama_produk, SUM(tbl_order_detail.jumlah) as total, 
    SUM(tbl_order_detail.harga) as harga FROM tbl_order_detail INNER JOIN tbl_order INNER JOIN tbl_produk ON (tbl_order_detail.id_order = tbl_order.id_order) 
    AND (tbl_order_detail.id_produk = tbl_produk.id_produk) GROUP BY tbl_produk.id_produk";
    $stmt = $db->prepare($query);
	$stmt->execute();
}

// $query = "SELECT tbl_produk.kode_produk, tbl_produk.nama_produk, SUM(tbl_order_detail.jumlah) as total, SUM(tbl_order_detail.harga) as harga FROM tbl_order_detail INNER JOIN tbl_order INNER JOIN tbl_produk ON (tbl_order_detail.id_order = tbl_order.id_order) 
//     AND (tbl_order_detail.id_produk = tbl_produk.id_produk) WHERE date(tbl_order.tgl_order) BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}' GROUP BY tbl_produk.id_produk";
// $stmt = $db->prepare($query);
// $stmt->execute();
require_once("../dompdf/dompdf_config.inc.php");

$total_harga = 0;

$kodeProduk = "";
$namaProduk = "";
$jumlah = "";
$harga = "";

$html =  '<h3 align="center">Laporan Penjualan</h3><br><br>
			<div>Tanggal : '.$tgl.'</div><br>
			<table style="width:100%;" border="1" color="black">
			  <tr>
			  	<th width="15%">Kode Produk</th>
			  	<th width="55%">Nama Produk</th>
			  	<th width="10%">Kuantitas</th>
			  	<th width="20%">Total Harga</th>
			  </tr>';
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	$kodeProduk = $row["kode_produk"];
	$namaProduk = $row["nama_produk"];
	$jumlah = $row["total"];
	$harga = $row["harga"];
	$total_harga += $row["harga"];
	$html .= '<tr>
			  	<td width="15%">'.$kodeProduk.'</td>
			  	<td width="55%">'.$namaProduk.'</td>
			  	<td width="10%" align="center">'.$jumlah.'</td>
			  	<td width="20%">Rp. '.number_format($harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan).'</td>
			  </tr>';
}
$html .= '<tr>
			<td colspan="2" align="center">Sub Total</td>
			<td colspan="2" align="center">Rp. '.number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan).'</td>
		  </tr>';
$html .= '</table>';

// $html =
//   '<html><body>'.
//   '<div align="center"><h3>Laporan Penjualan</h3></div>'.
//   '<br><br><br>
//   <table >
// 	  <tr>
// 	  	<td>Kode Produk</td>
// 	  	<td>Nama Produk</td>
// 	  	<td>Jumlah Terjual</td>
// 	  	<td>Total Harga</td>
// 	  </tr>
// 	  <tr>
// 	  	<td>''</td>
// 	  	<td>Nama Produk</td>
// 	  	<td>Jumlah Terjual</td>
// 	  	<td>Total Harga</td>
// 	  </tr>
//   </table>'.
  
//   '</body></html>';

$dompdf = new DOMPDF();
$dompdf->set_paper('a4', 'portrait');
//$dompdf->load_html($html);
$dompdf->load_html(html_entity_decode($html));
$dompdf->render();
//$dompdf->stream('Laporan_penjualan'.$nama.'.pdf');
//$dompdf->stream('Laporan Penjualan.pdf');
$dompdf->stream(
  'Laporan Penjualan.pdf',
  array(
    'Attachment' => 0
  )
);
?>