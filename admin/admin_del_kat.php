<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";
  require_once "../class/Produk.php";

  $admin = new Admin($db);
  $produk = new Produk($db);

  $roles = $admin->getAdmin();

  $admin->cekLogin();
    
    if(isset($_REQUEST['id'])) {

    	$id = $_REQUEST['id'];

        try {
            $produk->delKategori($id);
            header("Location: admin_data_kat.php");
        } catch (Exception $e) {
            die($e->getMessage());
            header("Location: admin_data_kat.php");
        }
    }
    
?>