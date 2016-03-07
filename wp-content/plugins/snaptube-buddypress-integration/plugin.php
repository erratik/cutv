<?php
/**
 * Plugin Name: WordPress Video Gallery BuddyPress Integration
 * Description: This contains WordPress Video Gallery related functionality for BuddyPress.
 * Version: 2.0
 * Author: Cohhe
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

// Plugin Directory 
define( 'SBP_DIR', dirname( __FILE__ ) );

// Scripts and Styles
include_once( SBP_DIR . '/lib/scripts_and_styles.php' );

// Post Types
// include_once( SBP_DIR . '/lib/functions/post-types.php' );

// Taxonomies 
//include_once( SBP_DIR . '/lib/functions/taxonomies.php' );

// Metaboxes
// include_once( SBP_DIR . '/lib/functions/metaboxes.php' );
 
// Shortcodes
// include_once( SBP_DIR . '/lib/functions/shortcodes.php' );

// Widgets
//include_once( SBP_DIR . '/lib/widgets/widget-social.php' );

// Twitter widgets
// include_once( SBP_DIR . '/lib/widgets/twitter/twitter.php' );

// Editor Style Refresh
include_once( SBP_DIR . '/lib/functions/editor-style-refresh.php' );

// General
include_once( SBP_DIR . '/lib/functions/general.php' );

// Submit a video
include_once( SBP_DIR . '/lib/functions/submit_video.php' );

require_once( plugin_dir_path( __FILE__ ) . 'lib/functions/page-template.php' );
add_action( 'plugins_loaded', array( 'vh_Page_Template_Plugin', 'get_instance' ) );

function vh_buddypress_localize() {
	load_plugin_textdomain( 'vh', false, dirname( plugin_basename( __FILE__ ) ).'/languages' );
}
add_action( 'plugins_loaded', 'vh_buddypress_localize' );