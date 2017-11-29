<?php

  require_once "class/db_koneksi.php";
  require_once "class/User.php";
  require_once "class/Produk.php";

  $user = new User($db);

  if(!$user->isUserLoggedIn()){
    header("location: login.php");
  }

  $produk = new Produk($db);
    
  if(isset($_REQUEST['del_id'])) {

  	$id = $_REQUEST['del_id'];

      try {
          $produk->delCart($id);
          header("Location: cart.php");
      } catch (Exception $e) {
          die($e->getMessage());
      }
  }
    
?>