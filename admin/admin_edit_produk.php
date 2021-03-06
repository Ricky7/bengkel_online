<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";
  require_once "../class/Produk.php";

  $admin = new Admin($db);
  $produk = new Produk($db);

  $roles = $admin->getAdmin();

  $ktg = $produk->getKategori();

  if(isset($_REQUEST['id']))
  {
      $id = $_REQUEST['id'];
      extract($produk->getProdukID($id));
      extract($produk->getKategoriID($id_kategori));
  }

  $admin->cekLogin();

  if(isset($_POST['submit'])) {

      $imgFile = $_FILES['gambar']['name'];
      $tmp_dir = $_FILES['gambar']['tmp_name'];
      $imgSize = $_FILES['gambar']['size'];

      date_default_timezone_set('Asia/Jakarta');
      $tanggal = date('Y-m-d H:i:s');

      if(empty($imgFile)) {
        
        try {
          $produk->updateProduk(array(
            'id_kategori' => $_POST['kategori'],
            'kode_produk' => $_POST['kode_produk'],
            'nama_produk' => $_POST['nama_produk'],
            'merk' => $_POST['merk'],
            'harga' => $_POST['harga'],
            'deskripsi' => $_POST['deskripsi'],
            'berat' => $_POST['berat'],
            'tgl_update' => $tanggal,
            'stok' => $_POST['stok']
          ), $id);
          header("location: admin_data_produk.php");
        } catch (Exception $e) {
          die($e->getMessage());
        }

      } else {
        $upload_dir = '../assets/image_produk/'; // upload directory
 
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
              $errMSG = "Maaf, ukuran file anda terlalu besar.";
            }
        } else {
            $errMSG = "Maaf, hanya ekstensi JPG, JPEG, PNG & GIF yang diterima.";  
        }

        if(!isset($errMsg)) {

          try {
            $produk->updateProduk(array(
              'id_kategori' => $_POST['kategori'],
              'kode_produk' => $_POST['kode_produk'],
              'nama_produk' => $_POST['nama_produk'],
              'merk' => $_POST['merk'],
              'harga' => $_POST['harga'],
              'deskripsi' => $_POST['deskripsi'],
              'gambar' => $userpic,
              'berat' => $_POST['berat'],
              'tgl_update' => $tanggal,
              'stok' => $_POST['stok']
            ), $id);
            header("location: admin_data_produk.php");
          } catch (Exception $e) {
            die($e->getMessage());
          }
        }
      }
      
      

      
    }
?>

<?php

  include "admin_header.php";

?>
<div class="container">
  <ul class="nav nav-tabs">
    <li role="presentation"><a href="admin_data_produk.php">Daftar Produk</a></li>
    <li role="presentation"><a href="admin_add_produk.php">Tambah Produk</a></li>
    <li role="presentation" class="active"><a href="#">Edit Produk</a></li>
  </ul>

  <div class="row">
    <div class="col-md-12" style="padding-bottom:20px;">
      <h4 align="center">Edit Produk</h4>
    </div>
    <div class="col-md-4">
      <form method="post" enctype="multipart/form-data">
        <small>Nama Produk</small>
        <div class="form-group" style="padding-top:10px;">
          <input type="text" value="<?php echo $nama_produk; ?>" name="nama_produk" class="form-control" placeholder="Nama Produk" aria-describedby="basic-addon1" required>
        </div>
    </div>

    <div class="col-md-4">
      <small>Kategori Produk</small>
      <div class="form-group" style="padding-top:10px;">
          <select name="kategori" class="form-control" required>
            <option value="<?php echo $id_kategori; ?>"><?php echo $nama_kategori; ?></option>
            <?php foreach ($ktg as $value): ?>
            <option value="<?php echo $value['id_kategori']; ?>"><?php echo $value['nama_kategori']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
    </div>


    <div class="col-md-4">
      <small>Kode Produk</small>
      <div class="form-group" style="padding-top:10px;">
          <input type="text" value="<?php echo $kode_produk; ?>" name="kode_produk" class="form-control" placeholder="Kode Produk" aria-describedby="basic-addon1" required>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <small>Merk</small>
      <div class="form-group" style="padding-top:10px;">
        <input type="text" value="<?php echo $merk; ?>" name="merk" class="form-control" placeholder="Merk Produk" aria-describedby="basic-addon1" required>
      </div>
    </div>
    <div class="col-md-4">
      <small>Harga</small>
      <div class="form-group" style="padding-top:10px;">
        <input type="number" value="<?php echo $harga; ?>" name="harga" class="form-control" placeholder="Harga Produk" aria-describedby="basic-addon1" required>
      </div>
    </div>
    <div class="col-md-4">
      <small>Gambar</small>
      <div class="form-group" style="padding-top:10px;">
        <input type="file" name="gambar" class="form-control" aria-describedby="basic-addon1">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <small>Berat /.gr</small>
      <div class="form-group" style="padding-top:10px;">
        <input type="number" value="<?php echo $berat; ?>" name="berat" class="form-control" placeholder="Berat Produk" aria-describedby="basic-addon1" required>
      </div>
    </div>
    <div class="col-md-4">
      <small>Deskripsi</small>
      <div class="form-group" style="padding-top:10px;padding-bottom:10px;">
        <textarea name="deskripsi" class="form-control" Placeholder="Deskripsi Produk" rows="5" required><?php echo $deskripsi; ?></textarea>
      </div>
    </div>
    <div class="col-md-4">
      <small>Stok</small>
      <div class="form-group" style="padding-top:10px;">
        <input type="number" value="<?php echo $stok; ?>" name="stok" class="form-control" placeholder="Stok Produk" aria-describedby="basic-addon1" required>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <center>
        <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
      </center>
      </form>
    </div>
  </div>
<div>
<?php

  include "admin_footer.php";

?>