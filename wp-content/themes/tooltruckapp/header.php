<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Tool Truck APP
 * @since Tool Truck APP 1.0
 */
$favIcon = of_get_option("fav_icon");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<?php 
		$id 	= get_the_ID(); 
		$title 	= get_the_title($id);
	?>
	<title><?php echo $title; ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<link rel="icon" href="<?php echo $favIcon; ?>" >
	<?php wp_head(); 	
	
	$logo = of_get_option("upload_logo");
	$mail = of_get_option("email_address_one");
	?>	
</head>
<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">	
		<div id="MainHeader" class="affix-top">
			<div class="container">
				<div class="topMenuContainer">
				<div class="logoimg col-lg-3 col-md-3 col-sm-3 col-xs-9 no-pad">
					<div id="LogoSec">
						<a class="toltrack_logo" href="<?php echo site_url(); ?>">
							<?php 
								if($logo){
									?>
									<img src="<?php echo $logo; ?>" alt="logo" /> 
							<?php } ?>		
						</a>
					</div>
				</div>
				<div class="menu col-lg-9 col-md-9 col-sm-9 col-xs-9 hidden-xs hidden-sm no-pad">
					<div class="RightTop text-right">
						<div class="socialMailcontainer">
							<i class="fa fa-envelope-o"></i> <?php echo $mail; ?>
						</div>
							<?php do_shortcode('[socialmenu]'); ?>
					</div>
					
					<div id="Mainmenu">
						<?php
							if(isset($_COOKIE['WordpressLoginUserEmail']) && !empty($_COOKIE['WordpressLoginUserEmail'])){
								wp_nav_menu(array('menu'=>'top-menu'));
								
								
							}else{
								wp_nav_menu(array('menu'=>'Temp-top-menu'));
							}
						?>
					</div>
					<!-- <div id="Mainmenu">
						<ul>
							<li class="main_li">
								<?php wp_nav_menu( array( 'name' => 'Primary Menu','theme_location' => 'primary' ) );?>
							</li>

							<?php if(isset($_COOKIE['WordpressLoginUserEmail']) && !empty($_COOKIE['WordpressLoginUserId'])){ ?>
								<li class="register menuLogin"><a class="reg-btn" href="<?php echo site_url('/dashboard'); ?>">Dashboard</a></li>
							<?php } else {?>
							<li class="menuSignUp"><a href="<?php echo site_url('/dashboard/register'); ?>">Sign Up</a></li>
							<li class="menuLogin"><a href="<?php echo site_url('/dashboard/login'); ?>">Login</a></li>
							<?php } ?>			
							
						</ul>	
					</div> -->

	<?php 
	// $base = __DIR__ . '/../../../';
	// $CI = require_once($base."/dashboard/Ci.php");
	// if(!empty($CI))
	// {
		
	// }
	// else
	// {

	// }
	?>


				</div>
			</div> 
		</div> 
		</div>
	</header>	
	<div id="content" class="site-content">

<script type="text/javascript">
	jQuery(function(){
		var dashboardLogin = getCookie("WordpressLoginUserEmail");

		if(dashboardLogin != ""){

		}

	})
	function getCookie(name) {
	  var value = "; " + document.cookie;
	  var parts = value.split("; " + name + "=");
	  if (parts.length == 2) return parts.pop().split(";").shift();
	}


</script>





