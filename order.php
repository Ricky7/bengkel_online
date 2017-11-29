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

    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d H:i:s');
    //-----------------------------------------------------------------------------
    if(isset($_POST['submit'])) {

      //multiple select value
      $result = $_POST['ongkir'];
      $result_explode = explode('|', $result);

      if($_POST['kurir'] == 'pos') {
        $kurir = 'PT POS INDONESIA';
      } else if($_POST['kurir'] == 'jne') {
        $kurir = 'JNE';
       } else {
          $kurir = 'TIKI';
        }

      try {
          $produk->insertOrder(array(
            'id_user' => $dataUser['id_user'],
            'no_hp' => $_POST['no_hp'],
            'alamat' => $_POST['alamat'],
            'kabupaten' => $_POST['kabupaten'],
            'provinsi' => $_POST['provinsi'],
            'kodepos' => $_POST['kodepos'],
            'tgl_order' => $tanggal,
            'desk_order' => $_POST['desk_order'],
            'jasa_kurir' => $kurir,
            'jenis_paket' => $result_explode[0],
            'ongkir' => $result_explode[1],
            'berat_order' => $_POST['berat'],
            'status_order' => 'Tidak bayar'
          ), $dataUser['id_user']);
          header("location: index.php");
        } catch (Exception $e) {
        die($e->getMessage());
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
			<li>Pemesanan</li>
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
			<h3><span>Pemesanan</span></h3>
			<div class="checkout-left">	
				<div class="col-md-4 checkout-left-basket">
					<h4>Keranjang Anda</h4>
					<ul>
						<?php
							$produk->myCart($dataUser['id_user']);
						?>
					</ul>
				</div>
				<div class="col-md-8 address_form_agile">
				  <h4>Form Pemesanan</h4>
					<form method="post" class="creditly-card-form agileinfo_form">
						<section class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
								<div class="first-row form-group">
									<div class="controls">
										<!-- Kota Asal Toko -->
             				 			<Input type="hidden" value="278" id="asal" required> 
										<label class="control-label">No Handphone: </label>
										<input class="billing-address-name form-control" value="<?php echo $dataUser['no_hp']; ?>" style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' type="text" name="no_hp" placeholder="No Handphone" required>
									</div>

									<div class="controls">
										<label class="control-label">Alamat: </label>
									  	<textarea style="text-align: left;" class="form-control" name="alamat" required><?php echo $dataUser['alamat']; ?></textarea>
									</div>
									
						            <div class="controls">
										<label class="control-label">Provinsi </label>
										<?php  

							              //Get Data Provinsi
							              $curl = curl_init();

							              curl_setopt_array($curl, array(
							                CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
							                CURLOPT_RETURNTRANSFER => true,
							                CURLOPT_ENCODING => "",
							                CURLOPT_MAXREDIRS => 10,
							                CURLOPT_TIMEOUT => 30,
							                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							                CURLOPT_CUSTOMREQUEST => "GET",
							                CURLOPT_HTTPHEADER => array(
							                  "key: ab60697a32a845a7fea4e3969d3750cb"
							                ),
							              ));

							              $response = curl_exec($curl);
							              $err = curl_error($curl);

							              echo "<select id='provinsi' class='form-control option-w3ls' style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' required>";
							              echo "<option>Pilih Provinsi Tujuan</option>";
							              //echo "<option value='".$currentUser['provinsi']."'>".$currentUser['provinsi']."</option>";
							              $data = json_decode($response, true);
							              for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
							                echo "<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
							              }
							              echo "</select>";
							              //Get Data Provinsi

							            ?>
							            <input type="hidden" name="provinsi" id="provinsix" required>
									</div>
									<div class="controls">
										<label class="control-label">Kabupaten:</label>
									    <select class="form-control option-w3ls" style="height:40px;font-size:12pt;padding: 0em 0em 0em 0em;" id="kabupaten" required>
									    </select>
							             <input type="hidden" name="kabupaten" id="kabupatenx" required>
									</div>

									<div class="controls">
										<label class="control-label">Kodepos: </label>
										<input class="billing-address-name form-control" style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' type="number" name="kodepos" placeholder="Kodepos" required>
									</div>

									<div class="controls">
										<label class="control-label">Jenis Kurir: </label>
										 <select class="form-control option-w3ls" style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' id="kurir" name="kurir" required>
							                <option>-Pilih Kurir-</option>
							                <option value="pos">POS INDONESIA</option>
							                <option value="jne">JNE</option>
							                <option value="tiki">TIKI</option>                
							              </select>
									</div>
									
									<div class="controls">
										<label class="control-label">Biaya Kirim: </label>
										<select class="form-control option-w3ls"style='height:40px;font-size:12pt;padding: 0em 0em 0em 0em;' id="ongkir" name="ongkir" required>
										</select>
									</div>
									
									<div class="controls">
										<label class="control-label">Deskripsi: </label>
									  	<textarea style="min-width: 70%;" rows="3" class="form-control" name="desk_order" Placeholder="Catatan Pembelian bila ada..."></textarea>
									</div>
									<div class="controls">
										<!-- Berat (gr) -->
              							<?php
              								$produk->totalBerat($dataUser['id_user']);
              							?>
									</div>
								</div>
								<button class="submit check_out" name="submit" id="ubah">Kirim ke Alamat</button>
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

<script type="text/javascript">

  $(document).ready(function(){
    $('#provinsi').change(function(){
    	

      //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax 
      var prov = $('#provinsi').val();

          $.ajax({
              type : 'GET',
              url : 'http://localhost:9000/si_irfan/kabupaten.php',
              data :  'prov_id=' + prov,
          success: function (data) {
          	//alert('work');
	          //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
	          $("#kabupaten").html(data);
	        }
          });
    });

    $("#kurir").on('change', function(){
      //Mengambil value dari option select provinsi asal, kabupaten, kurir, berat kemudian parameternya dikirim menggunakan ajax 
      var asal = $('#asal').val();
      var kab = $('#kabupaten').val();
      var kurir = $('#kurir').val();
      var berat = $('#berat').val();

          $.ajax({
              type : 'POST',
              url : 'http://localhost:9000/si_irfan/ongkir.php',
              data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
          success: function (data) {

	          //jika data berhasil didapatkan, tampilkan ke dalam element div ongkir
	          $("#ongkir").html(data);
	        }
          });
    });
  });
</script>
<script>
    
    (function() {
    
        // get references to select list and display text box
        var p = document.getElementById('provinsi');
        var px = document.getElementById('provinsix');

        var k = document.getElementById('kabupaten');
        var kx = document.getElementById('kabupatenx');


        function getSelectedOption(p) {
            var opt;
            for ( var i = 0, len = p.options.length; i < len; i++ ) {
                opt = p.options[i];
                if ( opt.selected === true ) {
                    break;
                }
            }
            return opt;
        }

        function getSelectedOption(k) {
            var opt;
            for ( var i = 0, len = k.options.length; i < len; i++ ) {
                opt = k.options[i];
                if ( opt.selected === true ) {
                    break;
                }
            }
            return opt;
        }

        document.getElementById('ubah').onclick = function () {
            // access text property of selected option
            px.value = p.options[p.selectedIndex].text;
            kx.value = k.options[k.selectedIndex].text;
        }


        
    }());

</script>

<?php
	
	include "footer.php";

?>