<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";
  require_once "../class/Produk.php";

  $admin = new Admin($db);
  $produk = new Produk($db);

  $roles = $admin->getAdmin();

  $admin->cekLogin();

  if(isset($_REQUEST['slug'])) {

    $id_order = $_REQUEST['slug'];
    $data_produk = $produk->getOrderData($id_order);
    $data_kirim = $produk->getResi($id_order);
  }

  $jumlah_desimal = "0";
  $pemisah_desimal = ",";
  $pemisah_ribuan = ".";

  if(isset($_POST['submit'])) {

      try {
        $produk->ubahStatusOrder($id_order, $_POST['status_order'], $roles['id_admin']);
        header("location: admin_order_paid.php");
      } catch (Exception $e) {
      die($e->getMessage());
      }
  }

  if(isset($_POST['kirim'])) {

      //$alamat_kirim = $alamat.' '.$kabupaten.', '.$provinsi.', '.$kodepos;
      date_default_timezone_set('Asia/Jakarta');
      $tanggal_kirim = date('Y-m-d H:i:s');

      try {
          $produk->kirimBarang(array(
              'id_order' => $id_order,
              'alamat' => $data_produk['alamat'],
              'tgl_kirim' => $tanggal_kirim,
              'jasa_kurir' => $data_produk['jasa_kurir'],
              'paket_antar' => $data_produk['jenis_paket'],
              'berat_paket' => $data_produk['berat_order'],
              'no_resi' => $_POST['no_resi']
          ), $id_order);
          //header("Refresh:0");
          header("location: admin_order_sent.php");
      } catch (Exception $e) {
          die($e->getMessage());
      }
  }

?>
<?php

  include "admin_header.php";

?>

<div class="container">
  <ul class="nav nav-tabs">
    <li role="presentation"><a href="admin_order_pending.php">Menunggu</a></li>
    <li role="presentation"><a href="admin_order_paid.php">Dibayar</a></li>
    <li role="presentation"><a href="admin_order_sent.php">Dikirim</a></li>
    <li role="presentation"><a href="admin_order_finish.php">Selesai</a></li>
    <li role="presentation" class="active"><a href="#">Informasi Pesanan</a></li>
  </ul>

  <div class="row">
    <div class="col-md-6">
      <h4 align="center">Informasi Pesanan</h4>
      <table class="table table-bordered" style="text-align:center;">
        <thead>
          <th style="text-align:center;">Data</th>
          <th style="text-align:center;">Informasi</th>
        </thead>
        <tr>
          <td>Alamat</td>
          <td><?php echo $data_produk['alamat'].', '.$data_produk['kabupaten'] ?></td>
        </tr>
        <tr>
          <td>Kodepos</td>
          <td><?php echo $data_produk['kodepos'] ?></td>
        </tr>
        <tr>
          <td>Provinsi</td>
          <td><?php echo $data_produk['provinsi'] ?></td>
        </tr>
        <tr>
          <td>Tanggal Pesanan</td>
          <td><?php echo $data_produk['tgl_order'] ?></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td><?php echo $data_produk['desk_order'] ?></td>
        </tr>
        <tr>
          <td>Jenis Pengiriman</td>
          <td><?php echo $data_produk['jasa_kurir'].', '.$data_produk['jenis_paket'] ?></td>
        </tr>
        <tr>
          <td>Ongkos/Berat</td>
          <td><?php echo "Rp. ".number_format($data_produk['ongkir'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan).' / '.$data_produk['berat_order'] ?></td>
        </tr>
        <tr>
          <td>Data Pemesan</td>
          <td><?php echo $data_produk['jenis_bank'].' '.$data_produk['nama_rek'].' '.$data_produk['no_rek'] ?></td>
        </tr>
        <tr>
          <td>Nilai transfer</td>
          <td><?php echo "Rp. ".number_format($data_produk['nilai_transfer'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></td>
        </tr>
        <tr>
          <td>Catatan Transfer</td>
          <td><?php echo $data_produk['ket_transfer'] ?></td>
        </tr>
        <tr>
          <td>Status Pesanan</td>
          <td>
            <?php 
              switch ($data_produk['status_order']) {
                case 'Tunggu':
                  echo '<font color="red">Menunggu Konfirmasi</font>';
                  break;
                case 'Bayar':
                  echo '<font color="red">Lunas</font>';
                  break;
                case 'Dikirim':
                  echo '<font color="red">Sedang dikirim</font>';
                  break;
                case 'Selesai':
                  echo '<font color="red">Telah diterima</font>';
                  break;
            }
            ?>
          </td>
        </tr>
        <tr>
            <td>Bukti Transfer</td>
            <td><img src="../assets/img_bukti/<?php echo $data_produk['bukti'] ?>" class="img-responsive"></td>
        </tr>
      </table>
    </div>

    <div class="col-md-6">
      <h4 align="center">Informasi Produk</h4>
      <table class="table table-bordered" style="text-align:center;">
        <thead>
          <th style="text-align:center;">Produk</th>
          <th style="text-align:center;">Kode Produk</th>
          <th style="text-align:center;">Nama Produk</th>
        </thead>
        <tbody>
          <?php
            $produk->infoProdukOrder($id_order);
          ?>
        </tbody>
      </table>
      <!-- Form Switch -->
      <?php

        switch ($data_produk['status_order']) {

          case 'Tunggu':
            ?>
            <h4 align="center">Konfirmasi</h4>
              <form method="post">
                <small>Konfirmasi Pemesanan</small>
                <div class="form-group" style="padding-top:10px;">
                  <select name="status_order" class="form-control" required>
                    <option></option>
                    <option value="Tunggu">PENDING</option>
                    <option value="Bayar">DIBAYAR</option>
                  </select><br>
                  <center>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </center>
                </div>
              </form>
            <?php
            break;

          case 'Bayar':
            ?>
            <h4 align="center">Kirim Pesanan</h4>
              <form method="post">
                <small>Masukkan No Resi</small>
                <div class="form-group" style="padding-top:10px;">
                  <input type="text" name="no_resi" class="form-control" placeholder="No Resi Pengiriman" aria-describedby="basic-addon1" required><br>
                  <center>
                    <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
                  </center>
                </div>
              </form>
            <?php
            break;

          case 'Dikirim':
            ?>
            <br>
            <table class="table table-bordered" style="text-align:center;">
              <tr>
                <td>Tanggal Pengiriman</td>
                <td><?php echo $data_kirim['tgl_kirim'] ?></td>
              </tr>
              <tr>
                <td>No Resi</td>
                <td><?php echo $data_kirim['no_resi'] ?></td>
              </tr>
            </table>
            <br>
            <h4 align="center">Konfirmasi</h4>
              <form method="post">
                <small>Konfirmasi Pengiriman</small>
                <div class="form-group" style="padding-top:10px;">
                  <select name="status_order" class="form-control" required>
                    <option></option>
                    <option value="Selesai">Terkirim</option>
                  </select><br>
                  <center>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </center>
                </div>
              </form>
            <?php
            break;

          case 'Selesai':
            ?>

            <?php
            break;
          
          default:
            
            break;
        }

      ?>

    </div>
  </div>
<div>

<?php

  include "admin_footer.php";

?>