<?php
/*
	Template Name: Pricing Table Template
	Description: Tool Truck APP shortcode use with this template after login.
*/
require_once(ABSPATH."/wp-load.php" );
get_header();
global $post;						
?>


<?php echo do_shortcode("$post->post_content");	 ?>
<?php	
get_footer();	
?>
