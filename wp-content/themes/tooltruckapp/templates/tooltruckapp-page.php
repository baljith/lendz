<?php
/*
	Template Name: Tool Truck APP Default Template
	Description: Tool Truck APP shortcode use with this template after login.
*/
require_once(ABSPATH."/wp-load.php" );
get_header();


global $post;						
echo do_shortcode("$post->post_content");	



get_footer();	
?>
