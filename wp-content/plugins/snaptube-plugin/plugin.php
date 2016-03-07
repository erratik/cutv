<?php
/**
 * Plugin Name: Snaptube Functionality
 * Description: This contains all your site's core functionality so that it is theme independent.
 * Version: 2.2.1
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
define( 'BE_DIR', dirname( __FILE__ ) );

define('VH_SHORTCODES', get_template_directory() . '/functions/admin/visual-composer');

// Scripts and Styles
include_once( BE_DIR . '/lib/scripts_and_styles.php' );

// Post Types
include_once( BE_DIR . '/lib/functions/post-types.php' );

// Taxonomies 
//include_once( BE_DIR . '/lib/functions/taxonomies.php' );

// Metaboxes
include_once( BE_DIR . '/lib/functions/metaboxes.php' );
 
// Shortcodes
include_once( BE_DIR . '/lib/functions/shortcodes.php' );

// Widgets
//include_once( BE_DIR . '/lib/widgets/widget-social.php' );

// Twitter widgets
include_once( BE_DIR . '/lib/widgets/twitter/twitter.php' );

// Editor Style Refresh
include_once( BE_DIR . '/lib/functions/editor-style-refresh.php' );

// General
include_once( BE_DIR . '/lib/functions/general.php' );

function vh_snaptube_localize() {
	load_plugin_textdomain( 'vh', false, dirname( plugin_basename( __FILE__ ) ).'/languages' );
}
add_action( 'plugins_loaded', 'vh_snaptube_localize' );
