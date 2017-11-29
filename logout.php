<?php  

    require_once "class/db_koneksi.php";
	require_once "class/User.php";

    // Buat object user
    $user = new User($db);

    // Logout! hapus session user
    $user->logout();

    // Redirect ke login
    header('location: index.php');
 ?>