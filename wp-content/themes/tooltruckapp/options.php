<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'options_check'),
		'two' => __('Two', 'options_check'),
		'three' => __('Three', 'options_check'),
		'four' => __('Four', 'options_check'),
		'five' => __('Five', 'options_check')
		);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_check'),
		'two' => __('Pancake', 'options_check'),
		'three' => __('Omelette', 'options_check'),
		'four' => __('Crepe', 'options_check'),
		'five' => __('Waffle', 'options_check')
		);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
		);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
		);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'options_check'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Upload Logo', 'options_check'),
		'desc' => __('Upload a file( png, ico, jpg, gif or bmp ) from your computer (maximum size:30KB, Width X Height : 185 x 165 )', 'options_check'),
		'id' => 'upload_logo',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Footer Logo', 'options_check'),
		'desc' => __('Upload a file( png, ico, jpg, gif or bmp ) from your computer (maximum size:30KB, Width X Height : 185 x 165 )', 'options_check'),
		'id' => 'footer_logo',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Favicon Icon', 'options_check'),
		'desc' => __('Upload a file( png, ico, jpg, gif or bmp ) from your computer (maximum size:30KB, Width X Height : 32 x 32 )', 'options_check'),
		'id' => 'fav_icon',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Home Page Title Button Url', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Venue', 'options_check'),
		'desc' => __('Please enter the Venue Title', 'options_check'),
		'id' => 'venue_title',
		'type' => 'text');	
	$options[] = array(
		'name' => __('Venue View More', 'options_check'),
		'desc' => __('Please enter the Venue Button Url', 'options_check'),
		'id' => 'venue_button_url',
		'type' => 'text');
	$options[] = array(
		'name' => __('Team', 'options_check'),
		'desc' => __('Please enter the Team Title', 'options_check'),
		'id' => 'team_title',
		'type' => 'text');	
	$options[] = array(
		'name' => __('Team View More', 'options_check'),
		'desc' => __('Please enter the Teams Button Url', 'options_check'),
		'id' => 'team_button_url',
		'type' => 'text');
	$options[] = array(
		'name' => __('Partners ', 'options_check'),
		'desc' => __('Please enter the Partners Title', 'options_check'),
		'id' => 'partners_title',
		'type' => 'text');	
	$options[] = array(
		'name' => __('Partners Background', 'options_check'),
		'id' => 'partners_background',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Footer/Social Icons', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Social Icons', 'options_check'),
		'desc' => __('Please enter URL Below mention fields', 'options_check'),
		);

	$options[] = array(
		'name' => __('Facebook URL', 'options_check'),
		'desc' => __('Please enter the Facebook page link', 'options_check'),
		'id' => 'facebook_url',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Twitter URL', 'options_check'),
		'desc' => __('Please enter the twitter page link', 'options_check'),
		'id' => 'twitter_url',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Pinterest URL', 'options_check'),
		'desc' => __('Please enter the Pinterest page link', 'options_check'),
		'id' => 'pinterest_url',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Instragram URL', 'options_check'),
		'desc' => __('Please enter the Instragram page link', 'options_check'),
		'id' => 'instagram_url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Google URL', 'options_check'),
		'desc' => __('Please enter the Google page link', 'options_check'),
		'id' => 'google_url',
		'type' => 'text');

	$options[] = array(
		'name' => __('Youtube URL', 'options_check'),
		'desc' => __('Please enter the Youtube page link', 'options_check'),
		'id' => 'youtube_url',
		'type' => 'text');


	$options[] = array(
		'name' => __('Upload Footer Logo', 'options_check'),
		'desc' => __('Upload a file( png, ico, jpg, gif or bmp ) from your computer (maximum size:30KB, Width X Height : 125 x 140 )', 'options_check'),
		'id' => 'upload_footer_logo',
		'type' => 'upload');


	$options[] = array(
		'name' => __('Address', 'options_check'),
		'desc' => __('Enter Address', 'options_check'),
		/* 	'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_check' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ), */
		'id' => 'footer_address',
		'type' => 'editor',
		'settings' => $wp_editor_settings );	

	$options[] = array(
		'name' => __('Email Address', 'options_check'),
		'desc' => __('Please enter the Email address. This email is also appears in header', 'options_check'),
		'id' => 'email_address_one',
		'type' => 'text');

	$options[] = array(
		'name' => __('Email Address 2', 'options_check'),
		'desc' => __('Please enter the other Email address if you have. This email is only appears in footer', 'options_check'),
		'id' => 'email_address_two',
		'type' => 'text');


	$options[] = array(
		'name' => __('Phone 1', 'options_check'),
		'desc' => __('Please enter the phone number', 'options_check'),
		'id' => 'phone_one',
		'type' => 'text');

	$options[] = array(
		'name' => __('Phone 2', 'options_check'),
		'desc' => __('Please enter the phone number', 'options_check'),
		'id' => 'phone_two',
		'type' => 'text');

	$options[] = array(
		'name' => __('Footer Content', 'options_check'),
		'desc' => __('Enter Footer Description', 'options_check'),
		/* 	'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_check' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ), */
		'id' => 'footer_descption',
		'type' => 'editor',
		'settings' => $wp_editor_settings );	

	

	$options[] = array(
		'name' => __('Copyright', 'options_check'),
		'desc' => __('Enter Copyright Description Below Whatever you want to add.', 'options_check'),
		/* 	'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_check' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ), */
		'id' => 'copyright',
		'type' => 'editor',
		'settings' => $wp_editor_settings );	


	/* $options[] = array(
		'name' => __('Default Text Editor', 'options_check'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_check' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'media_buttons' => true
	);

	$options[] = array(
		'name' => __('Additional Text Editor', 'options_check'),
		'desc' => sprintf( __( 'This editor includes media button.', 'options_check' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor_media',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
 */
		return $options;
	}