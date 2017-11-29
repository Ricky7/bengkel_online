<?php
	
	require_once "class/db_koneksi.php";
	require_once "class/User.php";
	require_once "class/Produk.php";

	$user = new User($db);

	$produk = new Produk($db);

    if($user->isUserLoggedIn()){
        header("location: index.php");
    }

    //Jika ada data dikirim
    if(isset($_POST['daftar'])){
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Registrasi user baru
        if($user->register($nama, $no_hp, $username, $password)){
            // Jika berhasil set variable success ke true
            $success = true;
            header ("location: login.php");
        }else{
            // Jika gagal, ambil pesan error
            $error = $user->getLastError();
        }
    }

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Proses login user
        if($user->login($username, $password)){
            header("location: index.php");
        }else{
            // Jika login gagal, ambil pesan error
            $error = $user->getLastError();
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
			<li>Masuk & Daftar</li>
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
	<!-- login -->
		<div class="w3_login">
			<h3>Masuk & Daftar</h3>
			<div class="w3_login_module">
				<div class="module form-module">
				  <div class="toggle"><i class="fa fa-times fa-pencil"></i>
					<div class="tooltip">Klik disini</div>
				  </div>
				  <div class="form">
					<h2>Login to your account</h2>
					<form method="post">
					  <?php if (isset($error)): ?>
			              <div class="error">
			                  <?php echo $error ?>
			              </div>
			          <?php endif; ?>
					  <input type="text" name="username" placeholder="Username" required=" ">
					  <input type="password" name="password" placeholder="Password" required=" ">
					  <input type="submit" name="login" value="Login">
					</form>
				  </div>
				  <div class="form">
					<h2>Create an account</h2>
					<form method="post">
					  <?php if (isset($error)): ?>
			              <div class="error">
			                  <?php echo $error ?>
			              </div>
			          <?php endif; ?>
			          <?php if (isset($success)): ?>
			              <div class="success">
			                  Berhasil mendaftar. Silakan login!
			              </div>
			          <?php endif; ?>
					  <input type="text" name="username" placeholder="Username" required=" ">
					  <input type="password" name="password" placeholder="Password" required=" ">
					  <input type="text" name="nama" placeholder="Your Name" required=" ">
					  <input type="text" name="no_hp" maxlength="12" placeholder="Phone Number" required=" ">
					  <input type="submit" name="daftar" value="Register">
					</form>
				  </div>
				</div>
			</div>
			<script>
				$('.toggle').click(function(){
				  // Switches the Icon
				  $(this).children('i').toggleClass('fa-pencil');
				  // Switches the forms  
				  $('.form').animate({
					height: "toggle",
					'padding-top': 'toggle',
					'padding-bottom': 'toggle',
					opacity: "toggle"
				  }, "slow");
				});
			</script>
		</div>
		<!-- //login -->
	</div>
	<div class="clearfix"></div>
</div>
<!-- banner -->



<?php
	
	include "footer.php";

?>