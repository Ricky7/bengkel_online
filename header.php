<?php  
    // Lampirkan db dan User
    require_once "class/db_koneksi.php";
    $dataUser = $user->getUser();
    ob_start();

 ?>
<!DOCTYPE html>
<html>
<head>
<title>Serasi Bengkel</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Grocery Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome icons -->
<link href="assets/css/font-awesome.css" rel="stylesheet" type="text/css" media="all" /> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="assets/js/move-top.js"></script>
<script type="text/javascript" src="assets/js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
</head>
	
<body>
<!-- header -->
	<div class="agileits_header">
		<div class="w3l_offers">
			<a href="#"> 
				<?php
                    if(!$user->isUserLoggedIn()){

                        ?>
                            Selamat Berbelanja! Guest
                        <?php
                    } else {

                        ?>
                            <p>Selamat Berbelanja! 
								<?php echo $dataUser['nama'] ?>
							</p>
                        <?php
                    }
                ?>
			</a>
		</div>
		<div class="w3l_search">
			<form action="search.php" method="get">
				<input type="text" name="search" Placeholder ="Search a Product" required="">
				<input type="submit" value=" ">
			</form>
		</div>
		<div class="product_list_header">  
			<a href="cart.php">
                <fieldset>
                    <input type="submit" name="submit" value="View your cart" class="button" />
                </fieldset>
            </a>
		</div>
		<div class="w3l_header_right">
			<ul>
				<li class="dropdown profile_details_drop">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><span class="caret"></span></a>
					<div class="mega-dropdown-menu">
						<div class="w3ls_vegetables">
							<ul class="dropdown-menu drp-mnu">
								<?php
				                    if(!$user->isUserLoggedIn()){

				                        ?>
				                            <li><a href="login.php">Masuk</a></li> 
											<li><a href="login.php">Daftar</a></li>
				                        <?php
				                    } else {

				                        ?>
				                        	<li><a href="belanjaanku.php">Belanjaanku</a></li>
				                            <li><a href="logout.php">Keluar</a></li> 
				                        <?php
				                    }
				                ?>
							</ul>
						</div>                  
					</div>	
				</li>
			</ul>
		</div>
		
		<div class="clearfix"> </div>
	</div>
<!-- script-for sticky-nav -->
	<script>
	$(document).ready(function() {
		 var navoffeset=$(".agileits_header").offset().top;
		 $(window).scroll(function(){
			var scrollpos=$(window).scrollTop(); 
			if(scrollpos >=navoffeset){
				$(".agileits_header").addClass("fixed");
			}else{
				$(".agileits_header").removeClass("fixed");
			}
		 });
		 
	});
	</script>
<!-- //script-for sticky-nav -->
	<div class="logo_products">
		<div class="container">
			<div class="w3ls_logo_products_left">
				<h1><a href="index.php"><span>Bengkel</span> Online</a></h1>
			</div>
			
			<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<li><i class="fa fa-phone" aria-hidden="true"></i>(+0123) 234 567</li>
					<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="#">serasi@store.com</a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //header -->
