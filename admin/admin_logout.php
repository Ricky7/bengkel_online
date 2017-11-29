<?php  
  
    require_once "../class/db_koneksi.php";
    require_once "../class/Admin.php";


    $admin = new Admin($db);

    // Logout! hapus session user
    $admin->logout();

    // Redirect ke login
    header('location: admin_login.php');
 ?>