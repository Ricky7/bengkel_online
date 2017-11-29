<?php
	
	require_once "../class/db_koneksi.php";
  require_once "../class/Admin.php";

  $admin = new Admin($db);

  $roles = $admin->getAdmin();
  $role = $roles['peran'];

  if($admin->isLoggedIn()){
      
      switch ($role) {
        case 'admin':
          header("location: admin_index.php");
          break;
        
        default:
          header("location: admin_login.php");
          break;
      }
  }

  if(isset($_POST['kirim'])){
      $username = $_POST['username'];
      $password = $_POST['password'];

      // Proses login admin
      if($admin->login($username, $password)){
          
        switch ($role) {
          case 'admin':
            header("location: admin_index.php");
            break;
          
          default:
            header("location: admin_login.php");
            break;
        }

      }else{
          // Jika login gagal, ambil pesan error
          $error = $admin->getLastError();
      }
  }

?>

	<title>Admin</title>
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<style>
    @import "bourbon";

    body {
      background: #eee !important;  
    }

    .wrapper {  
      margin-top: 80px;
      margin-bottom: 80px;
    }

    .form-signin {
      max-width: 380px;
      padding: 15px 35px 45px;
      margin: 0 auto;
      background-color: #fff;
      border: 1px solid rgba(0,0,0,0.1);  
      text-align: center;

      .form-signin-heading,
      .checkbox {
        margin-bottom: 30px;
      }

      .checkbox {
        font-weight: normal;
      }

      .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        @include box-sizing(border-box);

        &:focus {
          z-index: 2;
        }
      }

      input[type="text"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
      }

      input[type="password"] {
        margin-bottom: 20px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }
    }

    </style>
<div class="container">
  <div class="wrapper">
    <form class="form-signin" method="post">       
      <h2 class="form-signin-heading">Login</h2>
      <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
      <input type="password" class="form-control" name="password" placeholder="Password" required=""/>      
      <button class="btn btn-lg btn-primary btn-block" name="kirim" type="submit">Login</button>   
    </form>
  </div>
<div>
