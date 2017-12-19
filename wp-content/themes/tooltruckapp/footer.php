<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Tool Truck APP
 * @since Tool Truck APP 1.0
 */
$mail = of_get_option("email_address_one");
$address = of_get_option("footer_address");
$footerLogo = of_get_option("footer_logo");
$footerDesc = of_get_option("footer_descption");
$copyright = of_get_option("copyright");
?>
<footer id="siteFooter">	
	<div class="container">
		<div class="footerContainer clearfix">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-pad-left">
				<div class="footerLogoContainer">
					<?php if($footerLogo){
						?>
						<img src="<?php echo $footerLogo; ?>" />
					<?php } ?>
				</div>
				<div class="footerDescription"><?php echo $footerDesc; ?></div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<h3 class="footerHeadings underlineLeft">Company Info</h3>
				<div class="footerMenu">
					<?php
						if(isset($_COOKIE['WordpressLoginUserEmail']) && !empty($_COOKIE['WordpressLoginUserEmail'])){
							wp_nav_menu( array( 'menu' => 'Temp-footer-menu' ) );
						}else{
							wp_nav_menu( array( 'menu' => 'footer-menu' ) );
						}
					?>
					
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 no-pad-right">
				<h3 class="footerHeadings underlineLeft">Contact us</h3>
					<ul class="footerContact">
						<li class="footerAddress"><?php echo $address; ?></li>
						<li class="footerMail"><a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a></li>
					</ul>					
			</div>
		</div>
		<div class="col-lg-7 col-md-7 col-sm-8 col-xs-12 no-pad">
			<div class="copyrightSection">
				<?php echo $copyright; ?>
			</div>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-4 col-xs-12 no-pad text-right">
			<div class="footerSocial">
					<?php do_shortcode('[socialmenu]'); ?>
			</div>
		</div>
	</div>
</footer>
<script>
    jQuery( document ).ready(function() {
    	if(jQuery('#people_testimonials').length>0)
    	{
        jQuery("#people_testimonials").owlCarousel({
        items:2, 	 
        dots:true,        
        slideSpeed : 300,
        paginationSpeed : 400,                
        touchDrag: true,
        autoPlay : 3000,
        stopOnHover : true,
        margin:30, 
            responsive:{
      	  		0:{
            		items:1
       	 		},
       	 		600:{
            		items:2
       	 		},
				767:{
					items:2
				},				
				1000:{
            		items:2
        		}
    		}    
        
    			
        }); 
    }

    jQuery(window).scroll(function(){
	    var top = jQuery(window).scrollTop();
		if(top>1) // height of float header
		jQuery('#masthead').addClass('stick');
		else
		 jQuery('#masthead').removeClass('stick');
	})   
    });   
    </script>
<?php wp_footer(); ?>
</body>
</html>





