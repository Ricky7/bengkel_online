<?php

  require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";

  $admin = new Admin($db);

  $roles = $admin->getAdmin();

  $admin->cekLogin();
    
    if(isset($_REQUEST['id'])) {

    	echo $id = $_REQUEST['id'];

        try {
            $admin->delAdmin($id);
            header("Location: admin_data_adm.php");
        } catch (Exception $e) {
            die($e->getMessage());
            header("Location: admin_data_adm.php");
        }
    }
    
?>