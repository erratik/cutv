<?php
/*
 * Plugin Name: CUTV
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: CUTV | Concordia Television | enable functionality to link WP Video Gallery and Video Robot to work together to feed the snaptube theme functionality. all based off those two plugins.
 * Author: Tayana Jacques
 * Author URI: http://erratik.ca/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: cutv
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Tayana Jacques
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-cutv.php' ); // 
require_once( 'includes/class-cutv-settings.php' ); // any settings the user could set?

// include_once ('/cutv/wp-content/plugins/contus-video-gallery/admin/controllers/' . 'ajaxplaylistController.php');
// include_once ('/cutv/wp-content/plugins/contus-video-gallery/admin/controllers/' . 'videosController.php');
// include_once ('/cutv/wp-content/plugins/contus-video-gallery/admin/controllers/' . 'videosSubController.php');

// Load plugin libraries
require_once( 'includes/lib/class-cutv-admin-api.php' );
require_once( 'includes/lib/class-cutv-post-type.php' );
require_once( 'includes/lib/class-cutv-taxonomy.php' );


/* Including Wordpress Hooks */
require_once( 'includes/lib/cutv.hooks.php' );

/**
 * Returns the main instance of CUTV to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object CUTV
 */
function CUTV () {
	$instance = CUTV::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = CUTV_Settings::instance( $instance );
	}

	return $instance;
}

CUTV();
