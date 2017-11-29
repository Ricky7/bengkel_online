<?php

  require_once "class/db_koneksi.php";
  require_once "class/User.php";
  require_once "class/Produk.php";

  $user = new User($db);

  if(!$user->isUserLoggedIn()){
    header("location: login.php");
  }

  $produk = new Produk($db);
    
  if(isset($_REQUEST['slug'])) {

  	$id = $_REQUEST['slug'];
    $status = 'Selesai';

      try {
          $produk->ubahStatus($id, $status);
          header("Location: belanjaanku_selesai.php");
      } catch (Exception $e) {
          die($e->getMessage());
      }
  }
    
?>